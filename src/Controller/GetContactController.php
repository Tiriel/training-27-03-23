<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact', name: 'app_get_contact', methods: ['GET'])]
class GetContactController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'Contact',
        ]);
    }
}
