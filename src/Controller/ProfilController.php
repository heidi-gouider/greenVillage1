<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    private $utilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
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
}