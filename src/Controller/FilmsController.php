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
    public function ajouterFilm(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response
    {
        // Crée un nouveau film vide
        $film = new Films();

        // Crée le formulaire et le lie à l'entité
        $filmForm = $this->createForm(AjoutFilmFormType::class, $film);

        // Traite la requête
        $filmForm->handleRequest($request);

        // Vérifie si le formulaire est soumis et valide
        if ($filmForm->isSubmitted() && $filmForm->isValid()) {
            //  Récupère le fichier image depuis le formulaire
            $imageFile = $filmForm->get('affiche')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                //  Déplace le fichier dans le dossier prévu
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l’upload de l’image');
                }

                // Enregistre le nom du fichier dans l'entité
                $film->setAffiche($newFilename);
            }

            //  Persiste et flush l'entité
            $em->persist($film);
            $em->flush();

            $this->addFlash('success', 'Film ajouté avec succès !');

            return $this->redirectToRoute('app_profile');
        }

        // Récupérer uniquement les films avec affiche
        $filmsAvecAffiche = $em->getRepository(Films::class)
            ->createQueryBuilder('f')
            ->where('f.affiche IS NOT NULL')
            ->getQuery()
            ->getResult();

        // Affiche le formulaire
        return $this->render('films/ajout.html.twig', [
            'form' => $filmForm->createView(),
            'films' => $filmsAvecAffiche, // envoie seulement les films avec image
        ]);
    }


}
