<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Day;
use App\Entity\Worker;
use App\Entity\Sold;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Core\User\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/day")
 */
class DayController extends AbstractController
{
    /**
     * @Route("/select", name="select_day")
     */
    public function select_day()
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository(Location::class)->findAll();

        return $this->render('day/selectDay.html.twig', [
            'locations'=> $locations,
        ]);
    }
    
    /**
     * @Route("", methods={"POST"})
     */
    public function save_day(Request $request)
    {
        $id = $request->request->get('id');
        $hour_start = $request->request->get('hour_start');
        $hour_end = $request->request->get('hour_end');

        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository(Location::class)->find($id);

        $worker = new Worker();
        $day = new Day();

        $user = $this->getUser();

        $worker->setUser($user);
        $worker->setHourStart(new \DateTime($hour_start));
        $worker->setHourEnd(new \DateTime($hour_end));
        $worker->setMainSeller(true);

        //last expense
        $lastDay = $em->getRepository(Day::class)->findOneBy(["Location" => $location], ['id' => 'desc']);

        if(empty($lastDay)){
            $day->setCashPosition(0);
        }else{
            $day->setCashPosition($lastDay->getCashPosition());
        }

        $day->setLocation($location);
        $day->addWorker($worker);
        $day->setOpen(true);
        $day->setOpen(true);


        $em->persist($day);
        $em->persist($worker);
        $em->flush();

        return $this->redirectToRoute('day', ['id' => $day->getId()]);
    }

    /**
     * @Route("/open", name="open_day", methods={"POST"})
     */
    public function open_days(){
        $em = $this->getDoctrine()->getManager();

        // check if any day is open 
        $query = $em->createQuery(
            'SELECT D.id FROM App\Entity\Worker W
            INNER JOIN W.User U
            INNER JOIN W.day D
            WHERE D.Date = :date
            AND W.User = :id'
        )->setParameter('date', date("Y-m-d"))
         ->setParameter('id', $this->getUser());

        $day_id = $query->getResult();

        if(empty($day_id)){
            return $this->redirectToRoute('index');
        }else{
            return $this->redirectToRoute("day",[
                'id' => (int)$day_id[0]['id']
            ]);
        }
    }

     /**
     * @Route("/tableSold", name="tableSold", methods={"POST"})
     */
    public function tableSold(Request $request){
        $post = $request->request;
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');

        $day = $em->getRepository(Day::class)->find($id);
        $CashPosition = $day->getCashPosition();

        $sold = $em->getRepository(Sold::class)->findBy(['Day' => $day]);
        $serializer = $this->container->get('serializer');

        $sales = 0;
        $purchasePrice = 0;
        foreach($day->getSold()  as $product){
            $sales += $product->getPrice();
            $purchasePrice += $product->getPurchasePrice();
        }

        $sold_json = $serializer->serialize([$sold, $CashPosition, $sales, ($sales-$purchasePrice)], 'json', ['ignored_attributes' => ['Day']]);
       
        return new Response($sold_json); 
    }

    /**
     * @Route("/{id}", name="day", methods={"GET"})
     */
    public function get_day(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $day = $em->getRepository(Day::class)->find($id);

        // check day
        if(empty($day) or $day->getOpen() == false){
            return $this->redirectToRoute('index');
        }else{
            $worker = $em->getRepository(Worker::class)->findBy([
                'User' => $this->getUser(),
                'day' => $day
            ]);
            // check user
            if(empty($worker)){
                return $this->redirectToRoute('index');
            }else{
                // count expenses
                $expenses = 0;
                foreach($day->getExpenses()  as $expense){
                    $expenses += $expense->getWorth();
                }
                return $this->render('day/day.html.twig', [
                    'day'=> $day,
                    'expenses' => $expenses
                ]);
            }
        }
    }

    /**
     * @Route("/{id}/sold", methods={"POST"})
     */
    public function saveSold(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $day = $em->getRepository(Day::class)->find($id);
        $data = $request->request->get('data');
        if(empty($day)){
            // ERROR 
            $response = new Response();
            $response->setStatusCode(406);
            return $response;
        }else{
            $sold = new Sold();
            for($i=0; $i<count($data); $i++){
                switch($data[$i]['name']){
                    case 'product':
                        $sold->setProduct($data[$i]['value']);
                        break;
                    case 'price':
                        $sold->setPrice($data[$i]['value']);

                        // update CashPosition
                        $CashPosition = $day->getCashPosition(); 
                        $day->setCashPosition($CashPosition + $data[$i]['value']); 
                        break;
                    case 'purchase_price':
                        $sold->setPurchasePrice($data[$i]['value']);
                        break;
                    case 'facture':
                        $sold->setFacture($data[$i]['value']);
                        break;
                    case 'sale':
                        $sold->setSale($data[$i]['value']);
                        break;
                }
            }
            if($sold->getFacture()==''){
                $sold->setFacture(false);
            }

            $sold->setDay($day);
            $sold->setDate(new \DateTime());

            $em->persist($sold);
            $em->flush();

            return new JsonResponse('success');
        }
    }

    /**
     * @Route("/{id}/sold", methods={"DELETE"})
     */
    public function deleteSold(Request $request, Sold $sold): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        var_dump($sold->getId());
        // $entityManager->remove($sold);
        // $entityManager->flush();

        return $this->redirectToRoute('sold_index');
    }

    /**
     * @Route("/{id}/sold", methods={"PUT"})
     */
    public function updateSold(Request $request, Sold $sold): Response
    {
        $form = $this->createForm(SoldType::class, $sold);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sold_index');
        }

        return $this->render('sold/edit.html.twig', [
            'sold' => $sold,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/{id}/close", name="close_day")
     */
    public function close_day(int $id){
        $em = $this->getDoctrine()->getManager();
        $day = $em->getRepository(Day::class)->find($id);
        $worker = $em->getRepository(Worker::class)->findOneBy(["day" => $day, 'User' => $this->getUser()]);
      
        if(empty($day) || empty($worker)){
            return $this->redirectToRoute('index');
            // ERROR
        }else{
            $sales = 0;
            $purchasePrice = 0;
            foreach($day->getSold()  as $sold){
                $sales += $sold->getPrice();
                $purchasePrice += $sold->getPurchasePrice();
            }

            $day->setOpen(false);
            $day->getLocation()->setOpen(false);
            $em->flush();
            
            return $this->render('day/closeDay.html.twig', [
                'day'=> $day,
                'worker' => $worker,
                'sales' => $sales,
                'profit' => ($sales - $purchasePrice)
            ]);
        }
    }

}
