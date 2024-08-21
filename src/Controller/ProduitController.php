<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
// use App\Repository\RechercheRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\RechercheType;
use APP\Entity\Produit;
use APP\Entity\Categorie;
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

    // Gestion d'un formulaire de recherche
    #[Route('/recherche', name: 'app_recherche')]
    public function recherche(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        $produits = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // // Traitement des données du formulaire
            $data = $form->getData();
            $query = $data['query'];
            $categorie = $data['categorie'];

            // Construire la requête pour rechercher les produits
            $produitsRepo = $entityManager->getRepository(Produit::class);

            $qb = $produitsRepo->createQueryBuilder('p');

            if ($query) {
                $qb->andWhere('p.nom LIKE :query')
                   ->setParameter('query', '%' . $query . '%');
            }

            // Ajout d'une condition pour la catégorie. Si une catégorie a été sélectionnée,
            // on ajoute une autre condition WHERE pour filtrer les produits appartenant à cette catégorie
            if ($categorie) {
                $qb->andWhere('p.categorie = :categorie')
                   ->setParameter('categorie', $categorie);
            }

            $produits = $qb->getQuery()->getResult();
        }

        return $this->render('recherche.html.twig', [
            // return $this->render('base.html.twig', [
            'form' => $form->createView(),
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


