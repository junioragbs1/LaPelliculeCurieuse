<?php

namespace App\Controller;

use App\Entity\Series;
use App\Form\AjoutSeriesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/series', name: 'app_series_')]
final class SeriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Series $series): Response
    {
        return $this->render('series/index.html.twig', [
            'controller_name' => 'SeriesController',
            'note' => $series->getSerieAvis()
        ]);
    }

    // cette methode de controller servira a ajouter les films .
    #[Route('/ajouter', name: 'ajout')]
    public function ajouterSerie(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response
    {
        // Initialise une série vide
        $serie = new Series();

        // Crée le formulaire et lie-le à l'entité
        $serieForm = $this->createForm(AjoutSeriesFormType::class, $serie);

        // Traite la requête
        $serieForm->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($serieForm->isSubmitted() && $serieForm->isValid()) {
            // Récupère le fichier image depuis le formulaire
            $imageFile = $serieForm->get('affiche')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Déplace le fichier dans le dossier prévu
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l’upload de l’image');
                }

                // Enregistre le nom du fichier dans l'entité
                $serie->setAffiche($newFilename);
            }

            //Persiste et flush l'entité
            $em->persist($serie);
            $em->flush();

            $this->addFlash('success', 'La série a été ajoutée avec succès !');

            return $this->redirectToRoute('app_profile');
        }

        //Récupère toutes les séries avec affiche uniquement
        $seriesAvecAffiche = $em->getRepository(Series::class)->findBy(
            ['affiche' => true] // filtre les séries qui ont une image
        );

        // Affiche le formulaire
        return $this->render('series/ajout.html.twig', [
            'form' => $serieForm->createView(),
            'series' => $seriesAvecAffiche, // envoie uniquement les séries avec image
        ]);
    }

}
