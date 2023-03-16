<?php

namespace App\Controller;

use App\Entity\InvoiceLines;
use App\Form\InvoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    /*Method for View Invoice Lines Form*/
    #[Route('/invoice', name: 'invoice_index')]
    public function index(): Response
    {
        $i = new InvoiceLines();
        $form = $this->createForm(InvoiceType::class, $i, array('action' => $this->generateUrl('invoice_add')));
        $data['form'] = $form->createView();
        return $this->render('invoice/index.html.twig',$data);
    }

    /*Method for Add Invoice Lines*/
    #[Route('/invoice/add', name: 'invoice_add')]
    public function add(Request $request): Response
    {
        $i = new InvoiceLines();
        $form = $this->createForm(InvoiceType::class, $i);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $i = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($i);
            $em->flush();
            return $this->redirectToRoute('invoice_index');
        }

        return $this->render('base.html.twig');
    }
}
