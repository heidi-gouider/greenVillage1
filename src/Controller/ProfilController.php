<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Form\ProfilFormType;
use App\Form\ContactFormType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    private $utilisateurRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/profil', name: 'app_profil')]
    // #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        // Récuperation de l'identifiant unique de l'utilisateur connecté
        $identifiant = $this->getUser()->getUserIdentifier();
        // Vérification de la présence de l'utilisateur dans la bdd en lien avec le mail fournit par l'utilisateur
        if($identifiant){
            $info = $this->utilisateurRepository->findOneBy(["email" =>$identifiant]);
        }

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'informations' => $info
        ]);
    }

    #[Route('/profil/modif', name: 'app_profil_modif')]
    public function modifProfil(Request $request): Response
    {
        $utilisateur = $this->getUser();

        // Gérer la soumission du formulaire
        $form = $this->createForm(ProfilFormType::class, $utilisateur);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Sauvegarder les modifications en base de données
        // $entityManager = $this->getDoctrine()->getManager();
        $this->entityManager->flush();
        // $entityManager->flush();

        // $this->getDoctrine()->getManager()->flush();

        // Rediriger vers la page du profil
        return $this->redirectToRoute('app_profil');
    }

    // Afficher le formulaire
    return $this->render('profil/modif.html.twig', [
        'form' => $form->createView(),
    ]);
    }

}