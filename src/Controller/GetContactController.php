<?php

namespace App\Controller;

use App\Dto\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact', name: 'app_get_contact', methods: ['GET', 'POST'])]
class GetContactController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $dto = new Contact();
        $form = $this->createForm(ContactType::class, $dto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($dto);
            $this->addFlash('success', 'Your message has been sent');

            return $this->redirectToRoute('app_get_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
