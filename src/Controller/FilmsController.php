<?php

namespace App\Controller;

use App\Entity\Films;
use App\Form\AjoutFilmFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/films', name: 'app_films_')]
final class FilmsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
        ]);
    }


    // cette methode de controller servira a ajouter les films .
    #[Route('/ajouter', name: 'ajout')]
    public function ajouterFilm(Request $request, EntityManagerInterface $em): Response
    {
        // je initilialise une  film vide
        $film = new Films();

        // j'initialise le formulaire . le lie a mon controller
        $filmform = $this->createForm(AjoutFilmFormType::class, $film);

        //on va reqcuperer la reqiette dans les paramettre . on traite le formulaire .
        $filmform->handleRequest($request);

        // je verifier s'il est envoyer et valide
        if ($filmform->isSubmitted() && $filmform->isValid()) {
            $film = $filmform->getData();
            // on enregistre
            $em->persist($film);
            $em->flush(); // pour ecrire dans la base

            $this->addFlash('success' , 'le film a ete ajouter' );
        return $this->redirectToRoute('app_profile');
        }

        // maintenant je vais le lier a ma vue , au twig . il fera le html associer a ma methode
        return $this->render('films/ajout.html.twig', [
            'form' => $filmform->createView(),
        ]);
    }
}
