<?php

namespace App\Controller;

use App\Entity\Receipt;
use App\Form\ReceiptType;
use App\Repository\ReceiptRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/receipt", name="receipt.")
 */
class ReceiptController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ReceiptRepository $receiptRepository)
    {
        $receipts = $receiptRepository->findAll();

        return $this->render('$receipt/index.html.twig', [
            '$receipts' => $receipts
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $receipt = new Receipt();
        $form = $this->createForm(ReceiptType::class, $receipt);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($receipt);
            $em->flush();
            return $this->redirect($this->generateUrl('receipt.index'));
        }

        return $this->render('receipt/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete{id}", name="delete")
     */
    public function remove(Receipt $receipt)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($receipt);
        $em->flush();
        //$this->addFlash('information', 'Item was successfully removed');
        return $this->redirect($this->generateUrl('receipt.index'));
    }
}
