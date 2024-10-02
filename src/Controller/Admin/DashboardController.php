<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Produit;
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
    ){

    }
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
        // je recrée une section 'produit'
        yield MenuItem::section('Produits');
        yield MenuItem::section('Actions');

        // voir ce que la librairie utilise font-awesome ou bootstrap pour inclure des icones
        // je crée une liste d'actions pour les produits
        yield MenuItem::subMenu('Produits', 'fa fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un produit', 'fa fa-plus', Produit::class)->setAction('new'),
            MenuItem::linkToCrud('Afficher les produits', 'fa fa-eye', Produit::class),
            // Ajoutez d'autres actions ici
        ]);

                // je crée une liste d'actions pour les catégories
                yield MenuItem::subMenu('Catégories', 'fa fa-bars')->setSubItems([
                    // MenuItem::linkToCrud('Ajouter un produit', 'fa fa-plus', Categorie::class)->setAction(Crud::PAGE_NEW),
                    MenuItem::linkToCrud('Ajouter une catégorie', 'fa fa-plus', Categorie::class)->setAction('new'),
                    MenuItem::linkToCrud('Afficher les catégories', 'fa fa-eye', Categorie::class),
                    // Ajoutez d'autres actions ici
                ]);
        

        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
