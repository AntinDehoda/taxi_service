<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Order\OrderServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\OrderCreateType;

/**
 * The controller opens the main page with the order form.
 *
 * @author Anton Degoda <dehoda@ukr.net>
 */
final class DefaultController extends AbstractController
{

    /**
     * @Route("/")
     *
     * @param Request $request
     * @param OrderServiceInterface $orderService
     *
     * @return Response
     */
    public function index(Request $request, OrderServiceInterface $orderService): Response
    {
        $form = $this->createForm(OrderCreateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formDto = $form->getData();
            $orderTaxi = $orderService->create($formDto);

            return $this->redirectToRoute('action', [
                'id' => $orderTaxi->getId(),
            ]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
