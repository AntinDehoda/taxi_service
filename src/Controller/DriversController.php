<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Service\Taxi\TaxiServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DistrictType;

class DriversController extends AbstractController
{
    private $taxiService;

    public function __construct(TaxiServiceInterface $taxiService)
    {
        $this->taxiService = $taxiService;
    }

    /**
     * @Route("/drivers") name="drivers_index"
     *
     * @return Response
     */
    public function index()
    {
        $allTaxis = $this->taxiService->getAll();

        return $this->render('taxi/index.html.twig', [
        'taxis' => $allTaxis,
    ]);
    }

    /**
     * @Route("/disrict") name="district_view"
     *
     * @param Request $request
     *
     * @return Response
     */
    public function district_view(Request $request)
    {
        $form = $this->createForm(DistrictType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formDto = $form->getData();
            $taxis = $this->taxiService->getAllByDistrict($formDto->district);

            return $this->render('taxi/index.html.twig', [
                'taxis' => $taxis,
            ]);
        }

        return $this->render('taxi/district_view.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
