<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/oiseaux', name: 'oiseau_')]
class OiseauController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        return $this->render('oiseau/list.html.twig', [
            'controller_name' => 'OiseauController',
        ]);
    }
    #[Route("/details/{id}", name: 'details')]
    public function details(int $id): Response{
        return $this->render('oiseau/details.html.twig');
    }

    #[Route("/create", name: 'create')]
    public function create():Response
    {
        return $this->render("oiseau/create.html.twig");
    }
}
