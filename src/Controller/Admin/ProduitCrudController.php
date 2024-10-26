<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('parentCategorie'),
            AssociationField::new('categorie'), // Utiliser AssociationField pour les relations
            // pour que ce champ soit obligatoire
            // ->setRequired(true),
            TextField::new('libelle_produit'),
            TextEditorField::new('description_produit'),
            Field::new('imageFile', 'photo')
            // ->setFormType(VichFileType::class)
            ->onlyOnForms(),
            MoneyField::new('prix_achat_ht')
            ->setCurrency('EUR'),
            MoneyField::new('prix')
            ->setCurrency('EUR'),
            IntegerField::new('quantite_stock'),
        ];
    }
    
}
