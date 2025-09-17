<?php

namespace App\Controller;

use App\Entity\Films;
use App\Form\AjoutFilmFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/films', name: 'app_films_')]
final class FilmsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Films $films): Response
    {
        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
            'note' => $films->getFilmAvis()
        ]);
    }


    // cette methode de controller servira a ajouter les films .
    #[Route('/ajouter', name: 'ajout')]
    public function ajouterFilm(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        // 1️⃣ Crée un nouveau film vide
        $film = new Films();

        // 2️⃣ Crée le formulaire et le lie à l'entité
        $filmform = $this->createForm(AjoutFilmFormType::class, $film);

        // 3️⃣ Traite la requête
        $filmform->handleRequest($request);

        // 4️⃣ Vérifie si le formulaire est soumis et valide
        if ($filmform->isSubmitted() && $filmform->isValid()) {
            // 5️⃣ Récupère le fichier image depuis le formulaire
            $imageFile = $filmform->get('affiche')->getData();

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
                $film->setAffiche($newFilename);
            }

            // 8️⃣ Persiste et flush l'entité
            $em->persist($film);
            $em->flush();

            $this->addFlash('success', 'Film ajouté avec succès !');

            return $this->redirectToRoute('app_profile'); // redirection après ajout
        }

        // 9️⃣ Affiche le formulaire si pas soumis ou invalide
        return $this->render('films/ajout.html.twig', [
            'form' => $filmform->createView(),
        ]);
    }

}
