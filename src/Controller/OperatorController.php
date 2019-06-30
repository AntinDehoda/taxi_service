<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Form\OperatorLoginType;
use App\Service\Order\OrderServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperatorController extends AbstractController
{
    /**
     * @Route("/adm/")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        /** @var Form $form */
        $form = $this->createForm(OperatorLoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('operator/dashboard.html.twig');
        }

        return $this->render('operator/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/orders", name="showOrders")
     *
     * @param OrderServiceInterface $orderService
     *
     * @return Response
     */
    public function showOrders(OrderServiceInterface $orderService): Response
    {
        $orders = $orderService->getAll();

        return $this->render('operator/showOrders.html.twig', [
            'orders' => $orders,
        ]);
    }
}
