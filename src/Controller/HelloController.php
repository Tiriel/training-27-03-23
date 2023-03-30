<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HelloController extends AbstractController
{
    #[IsGranted('ROLE_CLOWN')]
    #[Route('/hello/{name<[a-zA-Z- ]*>?World}', name: 'app_hello_index', methods: ['GET'])]
    public function index(string $name, string $sfVersion): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            dump($sfVersion);
        }

        return $this->forward('hello/index.html.twig', [
            'controller_name' => "$name !",
        ]);
    }
}
