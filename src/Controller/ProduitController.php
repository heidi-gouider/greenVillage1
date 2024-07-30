<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use APP\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitController extends AbstractController
{
    private $produitRepository;

    public function __construct( produitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;

    }


    #[Route('/produit', name: 'app_produit')]


    public function index(): Response
    {
        $produit = $this->produitRepository->findAll();
        // dump($discs);

        
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'produit' => $produit,

        ]);
    }
}
