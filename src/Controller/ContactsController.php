<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Films;
use App\Form\AjoutAvisFormType;
use App\Form\AjoutFilmFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/contacts', name: 'app_contacts_')]
final class ContactsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('contacts/index.html.twig', [
            'controller_name' => 'ContactsController',
        ]);
    }

    #[Route('/ajouter', name: 'ajout')]
    public function ajouterAvis(Request $request, EntityManagerInterface $em): Response
    {
        // je initilialise une  film vide
        $avis = new Avis();

        // j'initialise le formulaire . le lie a mon controller
        $avisform = $this->createForm(AjoutAvisFormType::class, $avis);

        //on va reqcuperer la reqiette dans les paramettre . on traite le formulaire .
        $avisform->handleRequest($request);

        // je verifier s'il est envoyer et valide
        if ($avisform->isSubmitted() && $avisform->isValid()) {
            $avis = $avisform->getData();
            $avis->setIdUtilisateur($this->getUser());
            // on enregistre
            $em->persist($avis);
            $em->flush(); // pour ecrire dans la base

            return $this->redirectToRoute('app_profile');
        }

        // maintenant je vais le lier a ma vue , au twig . il fera le html associer a ma methode
        return $this->render('Avis/ajout.html.twig', [
            'form' => $avisform->createView(),
        ]);
    }
}
