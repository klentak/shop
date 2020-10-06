<?php

namespace App\Controller;

use App\Entity\Day;

use App\Entity\Expenses;
use App\Form\ExpensesType;
use App\Repository\ExpensesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/expenses")
 */
class ExpensesController extends AbstractController
{
    /**
     * @Route("/", name="expenses_index", methods={"GET"})
     */
    public function index(ExpensesRepository $expensesRepository): Response
    {
        return $this->render('expenses/index.html.twig', [
            'expenses' => $expensesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{day_id}/new", name="expenses_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $day_id): Response
    {
        $expense = new Expenses();
        $form = $this->createForm(ExpensesType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $day = $this->getDoctrine()->getRepository(Day::class)->find($day_id);
            $expense->setDay($day);
            $expense->setDate(new \DateTime());

            $entityManager->persist($expense);
            $entityManager->flush();

            return $this->redirectToRoute('day', ['id'=>$day_id]);
        }

        return $this->render('expenses/new.html.twig', [
            'expense' => $expense,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expenses_show", methods={"GET"})
     */
    public function show(Expenses $expense): Response
    {
        return $this->render('expenses/show.html.twig', [
            'expense' => $expense,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="expenses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Expenses $expense): Response
    {
        $form = $this->createForm(ExpensesType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expenses_index');
        }

        return $this->render('expenses/edit.html.twig', [
            'expense' => $expense,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expenses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Expenses $expense): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expense->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($expense);
            $entityManager->flush();
        }

        return $this->redirectToRoute('expenses_index');
    }
}
