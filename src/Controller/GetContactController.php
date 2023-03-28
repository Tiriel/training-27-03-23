<?php

namespace App\Controller;

use App\Dto\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact', name: 'app_get_contact', methods: ['GET'])]
class GetContactController extends AbstractController
{
    public function __invoke(): Response
    {
        $dto = new Contact();
        $form = $this->createForm(ContactType::class, $dto);

        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
