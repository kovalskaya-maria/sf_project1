<?php

namespace App\Controller;

use App\Entity\Reception;
use App\Form\ReceptionType;
use App\Repository\ReceptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reception", name="reception.")
 */
class ReceptionController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ReceptionRepository $receptionRepository)
    {
        $receptions = $receptionRepository->findAll();

        return $this->render('reception/index.html.twig', [
            'receptions' => $receptions
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $receptions = new Reception();
        $form = $this->createForm(ReceptionType::class, $receptions);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($receptions);
            $em->flush();
            return $this->redirect($this->generateUrl('reception.index'));
        }


        return $this->render('reception/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete{id}", name="delete")
     */
    public function remove(Reception $reception)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($reception);
        $em->flush();
        return $this->redirect($this->generateUrl('reception.index'));
    }
}
