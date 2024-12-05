<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Contact;
use App\Service\MailService;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class ContactController extends AbstractController
{
    private $categorieRepository;
// Injection du repository dans le constructeur
    public function __construct( CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;

    }

   #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer, AuthenticationUtils $authenticationUtils): Response
    {

        // Récupérer les catégories parentes pour la dropdown de la base sur la page contact
        $categories = $this->categorieRepository->findBy(['parent_categorie' => null]);
        // dd($categories);
        // $data = new ContactData();

        // Créer le formulaire
        //la méthode createForm() crée une instance du formulaire ContactFormType.
        //Ce formulaire sera affiché à l'aide de la méthode render() dans la vue index.html.twig
        $form = $this->createForm(ContactFormType::class);

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

            // Ajouter un message flash
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            // return $this->redirectToRoute('app_accueil');

            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();
        
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('contact/index.html.twig', [
            'form' => $form,
            'categories' => $categories,
            'error' => $error,
            'last_username' => $lastUsername,

        ]);
    }
    // #[Route('/contact', name: 'app_contact')]
    // public function categorie(CategorieRepository $categorieRepository): Response
    // {
         //on appelle la fonction `findAll()` du repository de la classe `Categorie` afin de récupérer toutes les categories de la base de données;
        //  $categories = $this->categorieRepository->findAll();
        //  $categories =$this->categorieRepository->findBy(['parent_categorie' => null]);

        // return $this->render('contact/index.html.twig', [
            // return $this->render('base.html.twig', [
            // 'controller_name' => 'AccueilController',
        //     'categories' => $categories,
        // ]);
    }



