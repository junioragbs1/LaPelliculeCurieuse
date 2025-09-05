<?php

namespace App\Controller;

use App\Entity\Series;
use App\Form\AjoutSeriesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/series', name: 'app_series_')]
final class SeriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('series/index.html.twig', [
            'controller_name' => 'SeriesController',
        ]);
    }

    // cette methode de controller servira a ajouter les films .
    #[Route('/ajouter', name: 'ajout')]
    public function ajouterSerie(Request $request, EntityManagerInterface $em): Response
    {
        // je initilialise une  film vide
        $serie = new Series();

        // j'initialise le formulaire . le lie a mon controller
        $serieform = $this->createForm(AjoutSeriesFormType::class, $serie);

        //on va reqcuperer la reqiette dans les paramettre . on traite le formulaire .
        $serieform->handleRequest($request);

        // je verifier s'il est envoyer et valide
        if ($serieform->isSubmitted() && $serieform->isValid()) {
            $serie = $serieform->getData();
            // on enregistre
            $em->persist($serie);
            $em->flush(); // pour ecrire dans la base

            $this->addFlash('success' , 'la serie a ete ajouter' );
            return $this->redirectToRoute('app_profile');
        }

        // maintenant je vais le lier a ma vue , au twig . il fera le html associer a ma methode
        return $this->render('series/ajout.html.twig', [
            'form' => $serieform->createView(),
        ]);
    }
}
