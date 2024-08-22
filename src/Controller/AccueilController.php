<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    
        //On va avoir souvent besoin d'injecter les respositories de nos entités dans les contrôleurs et les services
        //Pour ne pas les injecter dans chaque fonction, on va les instancier UNE SEULE fois dans le constructeur de notre contrôleur:
        //N'oubliez pas d'importer vos respositories (les lignes "use..." en haut de la page)
        private $categorieRepository;
        private $produitRepository;
    
        public function __construct(CategorieRepository $categorieRepository, ProduitRepository $produitRepository)
        {
            $this->categorieRepository = $categorieRepository;
            $this->produitRepository = $produitRepository;
    
        }
    
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
         //on appelle la fonction `findAll()` du repository de la classe `Categorie` afin de récupérer toutes les categories de la base de données;
        //  $categories = $this->categorieRepository->findAll();
         $categories =$this->categorieRepository->findBy(['parent_categorie' => null]);

        return $this->render('accueil/index.html.twig', [
            // return $this->render('base.html.twig', [
            // 'controller_name' => 'AccueilController',
            'categories' => $categories,
        ]);
    }

    // les categories parent
    #[Route('/categorie', name: 'app_categorie')]
    public function categorie(): Response
    {
        // Récupérer les catégories parentes
        $categories =$this->categorieRepository->findBy(['parent_categorie' => null]);
        // $categories = $this->categorieRepository->findAll();
        // dd($categories);
        return $this->render('accueil/categorie.html.twig', [
            // return $this->render('base.html.twig', [
            // 'controller_name' => 'AccueilController',
            'categories' => $categories
        ]);
    }

    // les sous-categories
    #[Route('/sous_categorie/{parent_categorie_id}', name: 'app_sous_categorie')]
    public function sousCategorie(int $parent_categorie_id): Response
    {
        // je récupère la categorie parent
        // $categories = $this->categorieRepository->find($parent_categorie_id);
        $categories = $this->categorieRepository->find($parent_categorie_id);
        //dd($parentCategorie);

        // je récupère les sous-categories
        $sousCategories = $categories->getCategories();
        // dd($categories);
        // dd($sousCategories);

        return $this->render('accueil/sousCategorie.html.twig', [
            // 'controller_name' => 'AccueilController',
            'categories' => $categories,
            'sous_categories' => $sousCategories,
            // 'parent_categorie' => $parentCategorie,
        ]);
    }

    // les instruments par categorie
    #[Route('/produits/{categorie_id}', name: 'app_produits_categorie')]
    public function produitCategorie(int $id, CategorieRepository $categorieRepository, ProduitRepository $produitRepository): Response
    {
        // je récupère la categorie correspondant à l'id
        $categorie = $this->categorieRepository->find($id);
        // dd($categorie);

        $produits = $categorie->getProduits();
        return $this->render('accueil/produitsCategorie.html.twig', [
            // return $this->render('base.html.twig', [
            // 'controller_name' => 'CatalogueController',
            'categories' => $categorie,
            'produits' => $produits,
        ]);
    }
}
