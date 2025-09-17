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
    public function ajouterSerie(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // 1️⃣ Initialise une série vide
        $serie = new Series();

        // 2️⃣ Crée le formulaire et lie-le à l'entité
        $serieform = $this->createForm(AjoutSeriesFormType::class, $serie);

        // 3️⃣ Traite la requête
        $serieform->handleRequest($request);

        // 4️⃣ Vérifie si le formulaire est soumis et valide
        if ($serieform->isSubmitted() && $serieform->isValid()) {
            // 5️⃣ Récupère le fichier image depuis le formulaire
            $imageFile = $serieform->get('affiche')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // 6️⃣ Déplace le fichier dans le dossier prévu
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l’upload de l’image');
                }

                // 7️⃣ Enregistre le nom du fichier dans l'entité
                $serie->setAffiche($newFilename);
            }

            // 8️⃣ Persiste et flush l'entité
            $em->persist($serie);
            $em->flush();

            $this->addFlash('success', 'La série a été ajoutée avec succès !');

            return $this->redirectToRoute('app_profile');
        }

        // 9️⃣ Affiche le formulaire si pas soumis ou invalide
        return $this->render('series/ajout.html.twig', [
            'form' => $serieform->createView(),
        ]);
    }

}
