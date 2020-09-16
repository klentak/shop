<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Day;
use App\Entity\Worker;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Core\User\User;

use Symfony\Component\HttpFoundation\Request;

class DayController extends AbstractController
{
    /**
     * @Route("/select_day", name="select_day")
     */
    public function select_day()
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository(Location::class)->findAll();

        return $this->render('day/newDay.html.twig', [
            'locations'=> $locations,
        ]);
    }
    
    /**
     * @Route("/new_day", name="new_day")
     */
    public function new_day(Request $request)
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
        $worker->setHourStart(new \DateTime($hour_end));
        $worker->setHourEnd(new \DateTime($hour_end));
        $worker->setMainSeller(true);
        
        $day->setLocation($location);
        $day->addWorker($worker);
        $day->setOpen(true);
        $day->setOpen(true);

        $em->persist($day);
        $em->persist($worker);
        $em->flush();

        return $this->redirectToRoute('index');

    }

    /**
     * @Route("/day/{id}", name="day", methods={"GET"})
     */
    public function day(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $day = $em->getRepository(Day::class)->find($id);

        if(empty($day)){
            return $this->redirectToRoute('index');
        }else{
            $worker = $em->getRepository(Worker::class)->findBy([
                'User' => $this->getUser(),
                'day' => $day
            ]);
            if(empty($worker)){
                return $this->redirectToRoute('index');
            }else{
                return $this->render('day/day.html.twig', [
                    'day'=> $day,
                ]);
            }
        }
    }
    /**
     * @Route("/open_days", name="opens_day")
     */
    public function open_days(){
        $em = $this->getDoctrine()->getManager();

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
                'id' => $day_id[0]['id']
            ]);
        }
    }

}
