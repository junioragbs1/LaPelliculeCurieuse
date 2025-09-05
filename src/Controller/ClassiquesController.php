<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClassiquesController extends AbstractController
{
    #[Route('/classiques', name: 'app_classiques')]
    public function index(): Response
    {
        return $this->render('classiques/index.html.twig', [
            'controller_name' => 'ClassiquesController',
        ]);
    }
}
