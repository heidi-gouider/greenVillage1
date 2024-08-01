<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
// use App\Repository\RechercheRepository;
use APP\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitController extends AbstractController
{
    private $produitRepository;
    private $rechercheRepository;


    public function __construct( ProduitRepository $produitRepository)
    {
        $this->ProduitRepository = $produitRepository;
        // $this->RechercheRepository = $rechercheRepository;
    }


    #[Route('/produit', name: 'app_produit')]


    public function index(): Response
    {
        $produits = $this->ProduitRepository->findAll();

        
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'produits' => $produits,

        ]);
    }


    //  #[Route('/produits', name: 'produit_list')]

    // public function list(Request $request, RechercheRepository $rechercheRepository): Response
    // {
    //     $searchTerm = $request->query->get('search', '');
        
    //     if ($searchTerm) {
    //         $produits = $rechercheRepository->searchByNom($searchTerm);
    //     } else {
    //         $produits = $rechercheRepository->findAll(); // on peut également créer une méthode `findAll` dans le même repository pour obtenir tous les produits
    //     }
        // dd($searchTerm)

        // if ($searchTerm) {
        //     $produits = $em->getRepository(Produit::class)->findByNom($searchTerm);
        // } else {
        //     $produits = $em->getRepository(Produit::class)->findAll();
        // }

        // return $this->render('produit/list.html.twig', [
        //     'produits' => $produits,
        //     'searchTerm' => $searchTerm
        // ]);
    }


