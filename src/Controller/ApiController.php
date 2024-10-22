<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    
    #Route[('/api/produits', name:'api_produits')]

    public function getProducts()
    {
        // Remplacez ceci par vos données de produits réelles
        $products = [
            ['id' => 1, 'libelleProduit' => 'Produit 1'],
            ['id' => 2, 'libelleProduit' => 'Produit 2'],
        ];

        return new JsonResponse($products);
    }

    #Route[('/api/categories', name:'api_categories')]
     
    public function getCategories()
    {
        // Remplacez ceci par vos données de catégories réelles
        $categories = [
            ['id' => 16, 'libelleCategorie' => 'les pianos'],
            ['id' => 20, 'libelleCategorie' => 'les batteries'],
        ];

        return new JsonResponse($categories);
    }
}