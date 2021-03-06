<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Service\Order\OrderServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OrderActionType;
use App\Form\OrderEditType;
use App\Form\OrderConfirmType;

/**
 * The controller opens the order management pages (pages of confirmation, editing, canceling)
 *
 * @author Anton Degoda <dehoda@ukr.net>
 */
class OrderController extends AbstractController
{
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @Route("/order/{id}", name="action", requirements={"id": "\d+"})
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function action(Request $request, int $id): Response
    {
        $order = $this->orderService->find($id);

        if (null == $order) {
            throw $this->createNotFoundException('There is no order with id=' . $id);
        }
        /** @var Form $form */
        $form = $this->createForm(OrderActionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * The order action page has 3 buttons (confirm, edit and cancel).
             *
             * @var string is formed depending on which button is pressed
             */
            $nextAction = $form->getClickedButton()->getName();

            if ('order_confirm' == $nextAction) {
                $this->addFlash('success', 'Your order was successfully confirmed!');
                $this->orderService->confirm($order);
            } elseif ('order_cancel' == $nextAction) {
                $cancelInfo = $this->orderService->cancel($order);
                $this->addFlash('success', 'Your order was successfully cancelled!');
                $this->addFlash('success', $cancelInfo);
            }

            return $this->redirectToRoute($nextAction, [
                'id' => $id,
            ]);
        }

        return $this->render('order/action.html.twig', [
            'form' => $form->createView(),
            'client' => (string) $order->getClient(),
            'taxi' => (string) $order->getTaxi(),
            'address' => (string) $order->getFromAddress(),
         ]);
    }
    /**
     * @Route("/order/{id}/edit", name="order_edit", requirements={"id": "\d+"})
     *
     * @param Request $request
     * @param int $id
     *
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

            return $this->redirectToRoute('action', [
                'id' => $id,
            ]);
        }

        return $this->render('order/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/order/{id}/confirm", name="order_confirm", requirements={"id": "\d+"})
     *
     * @param Request $request
     * @param int $id
     *
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

            /**
             * The confirmation page has 2 buttons (edit and cancel).
             *
             * @var string is formed depending on which button is pressed
             */
            $nextAction = $form->getClickedButton()->getName();

            if ('order_cancel' == $nextAction) {
                $cancelInfo = $this->orderService->cancel($order);
                $this->addFlash('success', 'Your order was successfully cancelled!');
                $this->addFlash('success', $cancelInfo);
            }

            return $this->redirectToRoute($nextAction, [
                'id' => $id,
            ]);
        }

        return $this->render('order/confirm.html.twig', [
            'form' => $form->createView(),
            'client' => (string) $order->getClient(),
            'taxi' => (string) $order->getTaxi(),
            'address' => (string) $order->getFromAddress(),
        ]);
    }
    /**
     * @Route("/order/{id}/cancel", name="order_cancel", requirements={"id": "\d+"})
     *
     * @return Response
     */
    public function cancel(): Response
    {
        return $this->render('order/cancel.html.twig');
    }
}
