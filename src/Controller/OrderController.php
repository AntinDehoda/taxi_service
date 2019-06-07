<?php

namespace App\Controller;

use App\Service\Order\OrderServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OrderConfirmType;
use App\Form\OrderEditType;

class OrderController extends AbstractController
{
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @Route("/order/{id}", name="order", requirements={"id": "\d+"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function confirm(Request $request, int $id): Response
    {
        $order = $this->orderService->find($id);
        if (null == $order) {
            throw $this->createNotFoundException('There is no order with id=' . $id);
        }
        /** @var Form $form */
        $form = $this->createForm(OrderConfirmType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $nextAction = $form->getClickedButton()->getName();
            if ($nextAction == 'order') {
                $this->addFlash('success', 'Your order was successfully confirmed!');
                $this->orderService->confirm($id);
            } elseif ($nextAction == 'order_cancel') {
                $this->addFlash('success', 'Your order was successfully cancelled!');
                $this->orderService->confirm($id);
            }

            return $this->redirectToRoute($nextAction,[
                'id' => $id
            ]);
        }

        return $this->render('order/order.html.twig', [
            'form' => $form->createView(),
            'client' => $order->getClient()->toString(),
            'taxi' => $order->getTaxi()->getPhone(),

        ]);
    }

    /**
     * @Route("/order/{id}/edit", name="order_edit", requirements={"id": "\d+"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, int $id): Response
    {
        $orderDto = $this->orderService->edit($id);
        if (null == $orderDto) {
            throw $this->createNotFoundException('There is no order with id=' . $id);
        }
        $form = $this->createForm(OrderEditType::class, $orderDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->orderService->update($orderDto, $id);
            $this->addFlash('success', 'Your order was successfully updated!');
            return $this->redirectToRoute('order',[
                'id' => $id
            ]);
        }

        return $this->render('order/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/order/{id}/cancel", name="order_cancel", requirements={"id": "\d+"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function cancel(Request $request, int $id): Response
    {
        $client = $this->orderService->cancel($id);
        if (null == $client) {
            throw $this->createNotFoundException('There is no order with id=' . $id);
        }

        return $this->render('order/cancel.html.twig', [
            'client' => $client,
        ]);
    }
}