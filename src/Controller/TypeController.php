<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type", name="type.")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(TypeRepository $typeRepository)
    {
        $types = $typeRepository->findAll();

        return $this->render('type/index.html.twig', [
            'types' => $types
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            return $this->redirect($this->generateUrl('type.index'));
        }


        return $this->render('type/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
    * @Route("/delete{id}", name="delete")
    */
    public function remove(Type $type)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($type);
        $em->flush();
        return $this->redirect($this->generateUrl('type.index'));
    }

}
