<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
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
    private $categorieRepository;



    public function __construct( ProduitRepository $produitRepository, CategorieRepository $categorieRepository)
    {
        $this->produitRepository = $produitRepository;
        // $this->RechercheRepository = $rechercheRepository;
        $this->categorieRepository = $categorieRepository;

    }


    #[Route('/produit', name: 'app_produit')]


    public function index(): Response
    {
        $produits = $this->produitRepository->findAll();

        
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'produits' => $produits,

        ]);
    }

    // Gestion d'un formulaire de recherche
    #[Route('/recherche', name: 'app_recherche')]
    // explication en détail dans notes
    public function recherche(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        $produits = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // // Traitement des données du formulaire
            $data = $form->getData();
            $query = $data['query'];
            $categories = $data['categorie'];

            // Construire la requête pour rechercher les produits
            $produitsRepo = $entityManager->getRepository(Produit::class);

            $qb = $produitsRepo->createQueryBuilder('p');

            if ($query) {
                $qb->andWhere('p.nom LIKE :query')
                   ->setParameter('query', '%' . $query . '%');
            }

            // Ajout d'une condition pour la catégorie. Si une catégorie a été sélectionnée,
            // on ajoute une autre condition WHERE pour filtrer les produits appartenant à cette catégorie
            if ($categories) {
                $qb->andWhere('p.categorie = :categorie')
                   ->setParameter('categorie', $categories);
            }

            $produits = $qb->getQuery()->getResult();
        }

        // return $this->render('recherche.html.twig', [
            return $this->render('base.html.twig', [
            'form' => $form->createView(),
            'produits' => $produits,
            // 'categories' => $categories,

        ]);
    }

            // les instruments par categorie
    #[Route('/produits/{id}', name: 'app_produits_categorie')]
    public function produitsCategorie(int $id, CategorieRepository $categorieRepository, ProduitRepository $produitRepository): Response
    {
        // je récupère la categorie correspondant à l'id
        $categorie = $this->categorieRepository->find($id);
        // $categorie = $this->categorieRepository->findAll();

        // dd($categorie);

    // Vérifier la catégorie existe
    // if (!$categorie) {
    //     throw $this->createNotFoundException('La catégorie n\'existe pas.');
    // }
        $produits = $categorie->getProduits();
        return $this->render('accueil/produitsCategorie.html.twig', [
            // return $this->render('base.html.twig', [
            // 'controller_name' => 'CatalogueController',
            'categories' => $categorie,
            'libelle_categorie' => $categorie->getLibelleCategorie(),
            'produits' => $produits,
        ]);
    }

        // le détail d'un produit
        #[Route('/detail_produit/{id}', name: 'app_detail_produit')]
        public function detailProduit(int $id, ProduitRepository $produitRepository): Response
        {
            // $produits = $this->produitRepository->findAll();
            $produit = $this->produitRepository->find($id);
            // dd($produits);
            // S'assurer que le produit existe
            if (!$produit) {
                throw $this->createNotFoundException('Le produit n\'existe pas.');
            }
            return $this->render('accueil/detailProduit.html.twig', [
                // 'controller_name' => 'AccueilController',
                'produit' => $produit,
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


