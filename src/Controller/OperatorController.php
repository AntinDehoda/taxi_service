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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperatorController extends AbstractController
{
    /**
     * @Route("/admin/", name="login")
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
        }

        return $this->render('operator/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
