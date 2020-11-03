<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Form\WorkerType;
use App\Repository\WorkerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/worker", name="worker.")
 */
class WorkerController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(WorkerRepository $workerRepository)
    {
        $workers = $workerRepository->findAll();

        return $this->render('worker/index.html.twig', [
            'items' => $workers
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $worker = new Worker();
        $form = $this->createForm(WorkerType::class, $worker);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($worker);
            $em->flush();
            return $this->redirect($this->generateUrl('worker.index'));
        }


        return $this->render('worker/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete{id}", name="delete")
     */
    public function remove(Worker $worker)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($worker);
        $em->flush();
        //$this->addFlash('information', 'Item was successfully removed');
        return $this->redirect($this->generateUrl('worker.index'));
    }
}
