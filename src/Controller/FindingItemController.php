<?php

namespace App\Controller;

use App\Form\FindingItemType;
use App\Repository\ReceptionRepository;
use App\Repository\SalesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

/**
 * @Route("/finding", name="finding.")
 */
class FindingItemController extends AbstractController
{
    private $employee;
    private $date;
    private $receptions;

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, ReceptionRepository $receptionRepository):Response
    {

        $form = $this->createForm(FindingItemType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->employee = $form->getData()['employee'];
            $this->date = $form->getData()['date'];
            $this->receptions = $receptionRepository->findReceptionsByEmployee($this->employee, $this->date);

            return $this->render('finding_item/index.html.twig', [
                'receptions' => $this->receptions,
                'employee' => $this->employee,
                'date' => $this->date,

            ]);
        }

        return $this->render('finding_item/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /* public function index(Request $request, SalesRepository $salesRepository)
    {
        $form = $this->createForm(FindingItemType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->type = $form->getData()['type'];
            $this->item = $salesRepository->findMostPopularItemByType($this->type);

            return $this->render('finding_item/index.html.twig', [
                'item' => $this->item,
            ]);
        }
        return $this->render('finding_item/form.html.twig', [
            'form' => $form->createView()
        ]);
    }*/

}
