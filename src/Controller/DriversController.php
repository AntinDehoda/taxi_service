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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DriversController extends AbstractController
{
    /**
     * @Route("/drivers") name="drivers_index"
     *
     * @param TaxiServiceInterface $taxiService
     *
     * @return Response
     */
    public function index(TaxiServiceInterface $taxiService)
    {
        $allTaxis = $taxiService->getAll();

        return $this->render('taxi/index.html.twig', [
        'taxis' => $allTaxis,
    ]);
    }
}
