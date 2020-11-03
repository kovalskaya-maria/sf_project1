<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employee", name="employee.")
 */
class EmployeeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EmployeeRepository $employeeRepository)
    {
        $employees = $employeeRepository->findAll();

        return $this->render('employee/index.html.twig', [
            'employees' => $employees
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();
            return $this->redirect($this->generateUrl('employee.index'));
        }


        return $this->render('employee/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/delete{id}", name="delete")
     */
    public function remove(Employee $employee)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($employee);
        $em->flush();
        //$this->addFlash('information', 'Item was successfully removed');
        return $this->redirect($this->generateUrl('employee.index'));
    }
}
