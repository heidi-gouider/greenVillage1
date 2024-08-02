<?php

namespace App\Controller;

use App\Form\ContactFormType;

//pour ajouter des contraintes de validatiob des données automatiquement
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Contact;

use App\Service\MailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
   #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        // $data = new ContactData();

        //la méthode createForm() crée une instance du formulaire ContactFormType.
        //Ce formulaire sera affiché à l'aide de la méthode render() dans la vue index.html.twig
        $form = $this->createForm(ContactFormType::class);
        // $form = $this->createForm(ContactFormType::class, $data);


        // Traitement des données soumises au formulaire
        $form->handleRequest($request);

        // je recupere les données transmises si le form est valide et envoyé
        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération de l'entité Contact associée au formulaire
            $contact = $form->getData();

            // Récupération des propriétés de l'entité Contact
            $address = $contact->getEmail();
            // $subject = $contact->getObjet();
            // $content = $contact->getMessage();
            $content = 'objet : ' . $contact->getObjet() . "\n";
            $content .= 'message : ' . $contact->getMessage();
            // dd($contact);

            $email = (new Email())
                ->from($address)
                ->to('green@village.com')						
                ->subject('demande de contact')
                ->text($content);

            // dd($email);
            $mailer->send($email);

            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('contact/index.html.twig', [
            //'controller_name' => 'ContactController',
            'form' => $form
        ]);
    }
}

