<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccueilController extends AbstractController
{
    
        //On va avoir souvent besoin d'injecter les respositories de nos entités dans les contrôleurs et les services
        //Pour ne pas les injecter dans chaque fonction, on va les instancier UNE SEULE fois dans le constructeur de notre contrôleur:
        //N'oubliez pas d'importer vos respositories (les lignes "use..." en haut de la page)
        private $categorieRepository;
        private $produitRepository;
    
        public function __construct(CategorieRepository $categorieRepository, ProduitRepository $produitRepository, AuthenticationUtils $authenticationUtils)
        {
            $this->categorieRepository = $categorieRepository;
            $this->produitRepository = $produitRepository;
    
        }
    
        // affichage des catégories et caroussel de produits
    #[Route('/', name: 'app_accueil')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les catégories principales (parent_categorie est null)
         $categories =$this->categorieRepository->findBy(['parent_categorie' => null]);
        // Utilisation du QueryBuilder pour récupérer les sous-catégories
        //  $sousCategories = $this->categorieRepository->find(['parent_categorie' => ['neq' => null]]);
         $sousCategories = $this->categorieRepository->createQueryBuilder('c')
        ->where('c.parent_categorie IS NOT NULL')
        ->getQuery()
        ->getResult();

        // Produits aléatoires
         $produitsAleatoires = $this->produitRepository->findAll();
        // mélange les produits
        shuffle($produitsAleatoires);


        // pour la modal
        $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('accueil/index.html.twig', [
            // return $this->render('base.html.twig', [
            // 'controller_name' => 'AccueilController',
            'categories' => $categories,
            'produitsAleatoires' => $produitsAleatoires,
            'sous_categories' => $sousCategories,
            // 'parent_categorie' => $parentCategorie,
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    // les categories parent
    #[Route('/categorie', name: 'app_categorie')]
    public function categorie(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les catégories parentes
        $categories =$this->categorieRepository->findBy(['parent_categorie' => null]);
        // $categories = $this->categorieRepository->findAll();
        // dd($categories);
                // pour la modal
                $error = $authenticationUtils->getLastAuthenticationError();
                $lastUsername = $authenticationUtils->getLastUsername();
            
        return $this->render('accueil/categorie.html.twig', [
            // return $this->render('base.html.twig', [
            'defaultImage' => 'default-image.jpg',
            'categories' => $categories,
            'error' => $error,
            'last_username' => $lastUsername,

        ]);
    }

    // les sous-categories
    #[Route('/sous_categorie/{parent_categorie_id}', name: 'app_sous_categorie')]
    public function sousCategorie(int $parent_categorie_id, AuthenticationUtils $authenticationUtils): Response
    {
        // je récupère la categorie parent
        $categories = $this->categorieRepository->find($parent_categorie_id);
        //dd($parentCategorie);

        // je récupère les sous-categories
        $sousCategories = $categories->getCategories();
        // dd($categories);
        // dd($sousCategories);
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('accueil/sousCategorie.html.twig', [
            // 'controller_name' => 'AccueilController',
            'categories' => $categories,
            'sous_categories' => $sousCategories,
            // 'parent_categorie' => $parentCategorie,
            'error' => $error,
            'last_username' => $lastUsername,

        ]);
    }

    // page à propos
    #[Route('/a propos}', name: 'app_a_propos')]
    public function aPropos(): Response
    {

        return $this->render('accueil/aPropos.html.twig', [
            // 'controller_name' => 'AccueilController',
            // 'categories' => $categories,
            // 'sous_categories' => $sousCategories,
            // 'parent_categorie' => $parentCategorie,
        ]);
    }

}

