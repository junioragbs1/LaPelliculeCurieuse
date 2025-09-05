<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\SeriesRepository;
use App\Repository\FilmsRepository;
use App\Entity\Films;
use App\Entity\Series;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(FilmsRepository $filmsRepository , SeriesRepository $seriesRepository): Response
    {
        return $this->render('profile/index.html.twig',
            [
                'films' => $filmsRepository->findAll(),
                'series' => $seriesRepository->findAll(),
            ]);
    }
}
