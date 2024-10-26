<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // je cache l'id dans les formulaire
            IdField::new('id')->hideOnForm(),
            TextField::new('libelle_categorie'),
            TextEditorField::new('description_categorie'),
            Field::new('imageFile', 'image_categorie')
                // ->setFormType(VichFileType::class)
                // ->onlyOnForms(),
                // >setBasePath('/uploads/images/categories') // Chemin d'accès pour l'affichage
                // ->setUploadDir('public/uploads/images/categories') // Dossier de stockage des uploads
                // >setBasePath('/IMG') // Chemin d'accès pour l'affichage
                // ->setUploadDir('public/IMG') // Dossier de stockage des uploads

            
        ];
    }
    
}
