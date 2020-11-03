<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("/item", name="item.")
*/
class ItemController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ItemRepository $itemRepository)
    {
        $items = $itemRepository->findAll();

        return $this->render('item/index.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
            return $this->redirect($this->generateUrl('item.index'));
        }


        return $this->render('item/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete{id}", name="delete")
     */
    public function remove(Item $item)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();
        //$this->addFlash('information', 'Item was successfully removed');
        return $this->redirect($this->generateUrl('item.index'));
    }
}
