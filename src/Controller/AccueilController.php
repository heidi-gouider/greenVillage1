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
    
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
         //on appelle la fonction `findAll()` du repository de la classe `Artist` afin de récupérer tous les artists de la base de données;
        //  $categorie = $this->categorieRepository->findAll();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            // 'categorie' => $categorie,
        ]);
    }

    #[Route('/categorie', name: 'app_categorie')]
    public function categorie(): Response
    {
        $categories = $this->categorieRepository->findAll();
        // dump($categorie);
        return $this->render('accueil/categorie.html.twig', [
            'controller_name' => 'AccueilController',
            'categories' => $categories
        ]);
    }
}
