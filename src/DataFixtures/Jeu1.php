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
        
                // Cration d'un produit
    $produit1 = new Produit();

    $produit1->setLibelleProduit("Guitare1");
        $produit1->setDescriptionProduit("Voici une super guitare");
        $produit1->setPrixAchatHt("150");
        $produit1->setPhoto("../IMG/guitarre1.webp");
        $produit1->setQuantiteStock("12");
        // $produit1->setReferenceFournisseur($fournisseurId);

        $manager->persist($produit1);
        // $product = new Product();
        // $manager->persist($product);
        $produit2 = new Produit();

        $produit2->setLibelleProduit("Guitare2");
            $produit2->setDescriptionProduit("Voici une guitare geniale");
            $produit2->setPrixAchatHt("250");
            $produit2->setPhoto("../IMG/guitare2.webp");
            $produit2->setQuantiteStock("10");
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
            // $produit1->setReferenceFournisseur($fournisseurId);
    
            $manager->persist($produit3);

            $Categorie = new Categorie();
        $Categorie->setProduit($produit1);
        $Categorie->setCategorie($produit2);
        // $Categorie->setRubrique("Instruments");
        $Categorie->setSousRubrique("Guitares");
        $Categorie->setParentCategorie("Instruments");
        $manager->persist($Categorie);

        // Ajout des relations de catégorie
        $produit1->addRubrique($produit2); 
        // produit1 a pour rubrique produit2
        $produit2->addSousRubrique($produit1); 
        // produit2 a pour sous-rubrique produit1

        $manager->flush();
    }
}
