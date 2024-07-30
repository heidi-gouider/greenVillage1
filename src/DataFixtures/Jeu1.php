<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Produit;
use App\Entity\Fournisseur;
use App\Entity\Categorie;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Cration d'un fournisseur
        $fournisseur1 = new Fournisseur();
        $fournisseur2 = new Fournisseur();


        $fournisseur1->setNomFournisseur("Super Fournisseur");
        $fournisseur1->setAdresseFournisseur("VRue de la joie");
        $fournisseur1->setTelephoneFournisseur("02 02 03 01 05");

        $fournisseur2->setNomFournisseur("Extra Fournisseur");
        $fournisseur2->setAdresseFournisseur("VRue de la musique");
        $fournisseur2->setTelephoneFournisseur("03 02 05 01 44");


        $manager->persist($fournisseur1);
        $manager->persist($fournisseur2);

        // $manager->flush()
        // Obtiens l'ID du fournisseur
        // $fournisseurId = $fournisseur->getId(); 

        // $fournisseurRepository = $manager->getRepository(Fournisseur::class);
        // $fournisseur = $fournisseurRepository->find($fournisseurId['fournisseur_id']); 
        // Récupère l'entité fournisseur
        // $fournisseurId = set


        // Création de la catégorie parent
        $parentCategorie = new Categorie;
        $parentCategorie->setParentCategorie($parentCategorie);
        $parentCategorie->setLibelleCategorie("Instruments à corde");
        $manager->persist($parentCategorie);

        
// Création de catégories
// $categorie = new Categorie();

$categorie1 = new Categorie();
// $categorie1->setParentCategorieId("1");
$categorie1->setParentCategorie($parentCategorie);
$categorie1->setLibelleCategorie("les pianos");
$categorie1->setDescriptionCategorie("les pianos sont supers");
$categorie1->setImageCategorie("../IMG/guitarre1.webp");


$manager->persist($categorie1);


$categorie2 = new Categorie();
$categorie2->setParentCategorie($parentCategorie);
$categorie2->setLibelleCategorie("Les guitare");
$categorie2->setDescriptionCategorie("les guitares");
$categorie2->setImageCategorie("../IMG/les_guitares.webp");


$manager->persist($categorie2);


$categorie3 = new Categorie();
$categorie3->setParentCategorie($parentCategorie);
$categorie3->setLibelleCategorie("les violons");
$categorie3->setDescriptionCategorie("les violons sont super");
$categorie3->setImageCategorie("../IMG/les_violons.webp");



$manager->persist($categorie3);


// $manager->flush();
        
                // Cration d'un produit
    $produit1 = new Produit();

    $produit1->setLibelleProduit("Guitare1");
        $produit1->setDescriptionProduit("Voici une super guitare");
        $produit1->setPrixAchatHt("150");
        $produit1->setPhoto("../IMG/guitarre1.webp");
        $produit1->setQuantiteStock("12");
        $produit1->setCategorie($categorie2);
        $produit1->setParentCategorie($parentCategorie);

        // $produit1->setReferenceFournisseur($fournisseurId);

        $manager->persist($produit1);
        $produit2 = new Produit();

        $produit2->setLibelleProduit("Guitare2");
            $produit2->setDescriptionProduit("Voici une guitare geniale");
            $produit2->setPrixAchatHt("250");
            $produit2->setPhoto("../IMG/guitare2.webp");
            $produit2->setQuantiteStock("10");
            $produit2->setCategorie($categorie2);
            $produit2->setParentCategorie($parentCategorie);

            // $produit1->setReferenceFournisseur($fournisseurId);
    
            $manager->persist($produit2);
            // $product = new Product();
            // $manager->persist($product);
    
            $produit3 = new Produit();

        $produit3->setLibelleProduit("Saxo1");
            $produit3->setDescriptionProduit("Voici un saxophone stylé");
            $produit3->setPrixAchatHt("2500");
            $produit3->setPhoto("../IMG/saxophone.webp");
            $produit3->setQuantiteStock("10");
            $produit3->setCategorie($categorie1);
            $produit3->setParentCategorie($parentCategorie);

            // $produit3->setCategorieId
            $manager->persist($produit3);

            // $produit1->setReferenceFournisseur($fournisseurId);
            $produit4 = new Produit();

    
            $produit4->setLibelleProduit("ViolonDingue");
            $produit4->setDescriptionProduit("Voici un violon trop cool");
            $produit4->setPrixAchatHt("450");
            $produit4->setPhoto("../IMG/guitare2.webp");
            $produit4->setQuantiteStock("5");
            $produit4->setCategorie($categorie3);
            $produit4->setParentCategorie($parentCategorie);


            $manager->persist($produit4);


 // Ajout des produits aux catégories
        $categorie2->addProduit($produit1);
        $categorie2->addProduit($produit2);
        $categorie1->addProduit($produit3);
        $categorie3->addProduit($produit4);

        // Ajout des relations de catégorie
        // $produit1->addRubrique($produit2); 
        // produit1 a pour rubrique produit2
        // $produit2->addSousRubrique($produit1); 
        // produit2 a pour sous-rubrique produit1
                // Liste de catégories à ajouter
                // $categories = [
                //     'categorieEnfant1',
                //     'categorieEnfant2',
                //     'categorieEnfant3',
                // ];
        
                // foreach ($categories as $catName) {
                //     $categorie = new Categorie();
                //     $categorie->setLibelleCategorie($catName); 
                //     $manager->persist($categorie);
                // }

        $manager->flush();
    }
}
