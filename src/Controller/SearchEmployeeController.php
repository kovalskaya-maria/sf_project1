<?php

namespace App\Controller;

use App\Form\SearchEmployeeType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search", name="search.")
 */
class SearchEmployeeController extends AbstractController
{
    private $item;
    private $type;
    private $employee;


    /**
     * @Route("/search/employee", name="search_employee")
     */
    public function index(Request $request, ItemRepository $itemRepository)
    {
        $form = $this->createForm(SearchEmployeeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->type= $form->getData()['type'];
            //$this->item = $itemRepository->findBy($itemRepository);
            $this->type = $itemRepository->findByTypeId($this->type);
            /*
            $this->destinationAirports = $airportRepository->findByCity($this->destinationCity);
            $this->ways = $wayRepository->findByDepAndDestAirports($this->departureAirports, $this->destinationAirports);
            $this->schedules = $scheduleRepository->findByWays($this->ways);*/

            return $this->render('search_employee/index.html.twig', [
                'types' => $this->type,
                'items' => $this->item,
            ]);
        }

        return $this->render('search_employee/search_result.html.twig', [
            'form' => $form->createView(),
            'title' => 'Choosing types',
        ]);

    }
}
