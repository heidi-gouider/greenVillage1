<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Entity\Fournisseur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {}
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ProduitCrudController::class)
            ->generateUrl();
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());
        return $this->redirect($url);
        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GreenVillage');
    }

    public function configureMenuItems(): iterable
    {
        // la méthode yield permet de retourner un élément comme un tableau sans le mot clé return
        // yield MenuItem::section('E-commerce');

        // les sections
        // yield MenuItem::section('Produits');
        // yield MenuItem::section('Clients');
        // yield MenuItem::section('Admin');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // Ajouter un lien vers l'accueil du site
        yield MenuItem::linkToUrl('Retour à l\'accueil', 'fas fa-arrow-left', $this->generateUrl('app_accueil'));

         // Création d'une section unique pour les produits et les catégories
    yield MenuItem::section('Produits & Catégories');
    // yield MenuItem::linkToRoute('Produits & Catégories', 'fa fa-box', 'admin', [
    //     'crudControllerFqcn' => ProduitCrudController::class
    // ]);

    // Sous-menu pour gérer les produits
    yield MenuItem::subMenu('Produits', 'fa fa-box')->setSubItems([
        MenuItem::linkToCrud('Ajouter un produit', 'fa fa-plus', Produit::class)->setAction('new'),
        MenuItem::linkToCrud('Afficher les produits', 'fa fa-eye', Produit::class),
    ]);

    // Sous-menu pour gérer les catégories
    yield MenuItem::subMenu('Catégories', 'fa fa-list')->setSubItems([
        MenuItem::linkToCrud('Ajouter une catégorie', 'fa fa-plus', Categorie::class)->setAction('new'),
        MenuItem::linkToCrud('Afficher les catégories', 'fa fa-eye', Categorie::class),
    ]);

        // voir ce que la librairie utilise font-awesome ou bootstrap pour inclure des icones
        // je crée une liste d'actions pour les produits
        // yield MenuItem::subMenu('Produits', 'fa fa-bars')->setSubItems([
        //     MenuItem::linkToCrud('Ajouter un produit', 'fa fa-plus', Produit::class)->setAction('new'),
        //     MenuItem::linkToCrud('Afficher les produits', 'fa fa-eye', Produit::class),
        // ]);

        // je crée une liste d'actions pour les catégories
        // yield MenuItem::subMenu('Catégories', 'fa fa-bars')->setSubItems([
        //     MenuItem::linkToCrud('Ajouter une catégorie', 'fa fa-plus', Categorie::class)->setAction('new'),
        //     MenuItem::linkToCrud('Afficher les catégories', 'fa fa-eye', Categorie::class),
        // ]);

                 // Création d'une section unique pour les clients
    yield MenuItem::section('Clients');
    // yield MenuItem::linkToRoute('Clients', 'fa fa-user', 'admin', [
    //     'crudControllerFqcn' => UtilisateurCrudController::class
    // ]);

    // Lien direct vers une vue générale (facultatif, enlève-le si non nécessaire)
yield MenuItem::linkToCrud('Vue générale des clients', 'fa fa-users', Utilisateur::class);

// Sous-menu pour les particuliers
yield MenuItem::subMenu('Particuliers', 'fa fa-user')->setSubItems([
    MenuItem::linkToCrud('Ajouter un particulier', 'fa fa-plus', Utilisateur::class)->setAction('new'),
    MenuItem::linkToCrud('Afficher les particuliers', 'fa fa-eye', Utilisateur::class)->setQueryParameter('type', 'particulier'), // Optionnel : ajouter un filtre spécifique
]);

// Sous-menu pour les professionnels (Pro)
yield MenuItem::subMenu('Professionnels', 'fa fa-briefcase')->setSubItems([
    MenuItem::linkToCrud('Ajouter un pro', 'fa fa-plus', Utilisateur::class)->setAction('new'),
    MenuItem::linkToCrud('Afficher les pros', 'fa fa-eye', Utilisateur::class)->setQueryParameter('type', 'pro'), // Optionnel : ajouter un filtre spécifique
]);


                         // Création d'une section unique pour les administrateurs
    yield MenuItem::section('Admin');
    yield MenuItem::linkToRoute('Admin', 'fa fa-eye', 'admin', [
        'crudControllerFqcn' => AdminCrudController::class
    ]);

        // je crée une liste d'actions pour les admin
        yield MenuItem::subMenu('Admin', 'fa fa-user-circle')->setSubItems([
            MenuItem::linkToCrud('Ajouter un admin', 'fa fa-plus', Admin::class)->setAction('new'),
            MenuItem::linkToCrud('Afficher les admin', 'fa fa-eye', Admin::class),
            // Ajoutez d'autres actions ici
        ]);

                // je crée une liste d'actions pour la gestion de stock
        yield MenuItem::section('Gestion de stock');

        // je crée une liste d'actions pour les fournisseurs
        yield MenuItem::subMenu('Fournisseurs', 'fa fa-handshake-o')->setSubItems([
            // MenuItem::linkToCrud('Ajouter un Fournisseur', 'fa fa-plus', Fournisseur::class)->setAction('new'),
            MenuItem::linkToCrud('Afficher les fournisseurs', 'fa fa-handshake-o', Fournisseur::class),
            // Ajoutez d'autres actions ici
        ]);


        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
