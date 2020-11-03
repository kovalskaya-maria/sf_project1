<?php

namespace App\Controller;

use App\Entity\Sales;
use App\Form\SalesType;
use App\Repository\SalesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sales", name="sales.")
 */
class SalesController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SalesRepository $salesRepository)
    {
        $sales = $salesRepository->findAll();

        return $this->render('sales/index.html.twig', [
            'sales' => $sales
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $sales = new Sales();
        $form = $this->createForm(SalesType::class, $sales);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sales);
            $em->flush();
            return $this->redirect($this->generateUrl('sales.index'));
        }


        return $this->render('sales/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete{id}", name="delete")
     */
    public function remove(Sales $sales)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($sales);
        $em->flush();
        //$this->addFlash('information', 'Item was successfully removed');
        return $this->redirect($this->generateUrl('sales.index'));
    }
}
