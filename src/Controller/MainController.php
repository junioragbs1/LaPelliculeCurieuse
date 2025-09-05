<?php

namespace App\Controller;

use App\Repository\SeriesRepository;
use App\Repository\FilmsRepository;
use App\Repository\ClassiquesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Films;
use App\Entity\Series;
use App\Entity\Classiques;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ClassiquesRepository $classiquesRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'Classiques' => $classiquesRepository->findAll(),
        ]);
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('main/mentions.html.twig');
    }
    #[Route('/contacts', name: 'app_contacts')]
public function contact(Request $request): Response
    {
        return $this->render('main/contacts.html.twig');
    }
}

