<?php
namespace App\Controller;

use App\Document\ContactMessage;
use App\Form\ContactMessageFormType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact' , name: 'app_contact_')]
class ContactMsgController extends AbstractController
{
    #[Route('/', name: 'contact_index', methods: ['GET', 'POST'])]
    public function index(Request $request, DocumentManager $dm): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageFormType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($contactMessage);

            $dm->persist($contactMessage);
            $dm->flush();


            return $this->redirectToRoute('app_contact_contact_index');
        }

        return $this->render('contactMsg/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
