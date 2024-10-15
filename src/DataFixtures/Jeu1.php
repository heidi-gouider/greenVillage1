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
                 // empêcher l'auto incrément
                 $metadata = $manager->getClassMetaData(Categorie::class);
                 $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        
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

        // foreach ($categorie as $categorie) {
        //     $artistDB = new Artist();
        //     $artistDB
        //         ->setId($art['artist_id'])
        //         ->setName($art['artist_name']);
            // ->setUrl($art['artist_url']);

            // $manager->persist($artistDB);

            // empêcher l'auto incrément
            // $metadata = $manager->getClassMetaData(Artist::class);
            // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        // }
        $manager->flush();

        // $manager->flush()
        // Obtiens l'ID du fournisseur
        // $fournisseurId = $fournisseur->getId(); 

        // $fournisseurRepository = $manager->getRepository(Fournisseur::class);
        // $fournisseur = $fournisseurRepository->find($fournisseurId['fournisseur_id']); 
        // Récupère l'entité fournisseur
        // $fournisseurId = set


        // Création de la catégorie parent
        $parentCategorie = new Categorie;
        // Attention c'est une categorie racine donc elle n'a pas de parent!
        // $parentCategorie->setParentCategorie($parentCategorie);
        $parentCategorie->setLibelleCategorie("Instruments à corde");
        $parentCategorie->setImageCategorie("IMG/instrument_a_corde.webp");

        $manager->persist($parentCategorie);

        $manager->flush(); // Persist et flush ici pour s'assurer que l'ID est disponible

        // Création de la catégorie parent2
        $parentCategorie2 = new Categorie;
        // $parentCategorie2->setParentCategorie($parentCategorie2);
        $parentCategorie2->setLibelleCategorie("Batterie et Percussions");
        $parentCategorie2->setImageCategorie("IMG/les_percussions.webp");

        $manager->persist($parentCategorie2);
        $manager->flush();
        
        // Création de la catégorie parent3
        $parentCategorie3 = new Categorie;
        // $parentCategorie2->setParentCategorie($parentCategorie2);
        $parentCategorie3->setLibelleCategorie("Instruments à vent");
        $parentCategorie3->setImageCategorie("IMG/instrument_a_vent.webp");
        
        $manager->persist($parentCategorie3);
        $manager->flush();
        
// Création de catégories enfants

$categorie1 = new Categorie();
// $categorie1->setParentCategorieId("1");
$categorie1->setParentCategorie($parentCategorie);
$categorie1->setLibelleCategorie("les pianos");
$categorie1->setDescriptionCategorie("les pianos sont supers");
$categorie1->setImageCategorie("IMG/piano.webp");


$manager->persist($categorie1);


$categorie2 = new Categorie();
$categorie2->setParentCategorie($parentCategorie);
$categorie2->setLibelleCategorie("Les guitares");
$categorie2->setDescriptionCategorie("les guitares");
$categorie2->setImageCategorie("IMG/guitarre2.webp");


$manager->persist($categorie2);


$categorie3 = new Categorie();
$categorie3->setParentCategorie($parentCategorie);
$categorie3->setLibelleCategorie("les violons");
$categorie3->setDescriptionCategorie("les violons sont super");
$categorie3->setImageCategorie("IMG/les_violons.webp");



$manager->persist($categorie3);

$categorie4 = new Categorie();
$categorie4->setParentCategorie($parentCategorie2);
$categorie4->setLibelleCategorie("les percussions");
$categorie4->setDescriptionCategorie("les Percus sont super");
$categorie4->setImageCategorie("IMG/djumbe.webp");



$manager->persist($categorie4);

$categorie5 = new Categorie();
$categorie5->setParentCategorie($parentCategorie2);
$categorie5->setLibelleCategorie("les xylophones");
$categorie5->setDescriptionCategorie("les xylophones sont super");
$categorie5->setImageCategorie("IMG/xylophone.webp");



$manager->persist($categorie5);

$categorie6 = new Categorie();
$categorie6->setParentCategorie($parentCategorie2);
$categorie6->setLibelleCategorie("les batteries");
$categorie6->setDescriptionCategorie("les batteries sont super");
$categorie6->setImageCategorie("IMG/batteries.webp");



$manager->persist($categorie6);

$categorie7 = new Categorie();
$categorie7->setParentCategorie($parentCategorie3);
$categorie7->setLibelleCategorie("les flutes");
$categorie7->setDescriptionCategorie("les flutes sont super");
$categorie7->setImageCategorie("IMG/les_flute.webp");



$manager->persist($categorie7);

// empêcher l'auto incrément
    $metadata = $manager->getClassMetaData(Categorie::class);
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                
// $manager->flush();
        
                // Cration d'un produit
    $produit1 = new Produit();

    $produit1->setLibelleProduit("Guitare1");
        $produit1->setDescriptionProduit("Voici une super guitare");
        $produit1->setPrixAchatHt("150");
        $produit1->setPhoto("IMG/guitarre1.webp");
        $produit1->setPrix("200");
        $produit1->setQuantiteStock("12");
        $produit1->setCategorie($categorie2);
        $produit1->setParentCategorie($parentCategorie);

        // $produit1->setReferenceFournisseur($fournisseurId);

        $manager->persist($produit1);
        $produit2 = new Produit();

        $produit2->setLibelleProduit("Guitare2");
            $produit2->setDescriptionProduit("Voici une guitare geniale");
            $produit2->setPrixAchatHt("250");
            $produit2->setPhoto("IMG/guitarre2.webp");
            $produit2->setPrix("300");
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
            $produit3->setPhoto("IMG/saxophone.webp");
            $produit3->setPrix("3000");
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
            $produit4->setPhoto("IMG/violon1.webp");
            $produit4->setPrix("500");
            $produit4->setQuantiteStock("5");
            $produit4->setCategorie($categorie3);
            $produit4->setParentCategorie($parentCategorie);


            $manager->persist($produit4);

            $produit5 = new Produit();

    
            $produit5->setLibelleProduit("Yamahe Rydeen");
            $produit5->setDescriptionProduit("Voici une batterie trop cool");
            $produit5->setPrixAchatHt("800");
            $produit5->setPhoto("IMG/Yamaha Rydeen.webp");
            $produit5->setPrix("850");
            $produit5->setQuantiteStock("3");
            $produit5->setCategorie($categorie6);
            $produit5->setParentCategorie($parentCategorie);


            $manager->persist($produit5);

            $produit6 = new Produit();

            $produit6->setLibelleProduit("millenium focus");
            $produit6->setDescriptionProduit("Voici une batterie trop cool");
            $produit6->setPrixAchatHt("389");
            $produit6->setPhoto("IMG/millenium focus.webp");
            $produit6->setPrix("430");
            $produit6->setQuantiteStock("3");
            $produit6->setCategorie($categorie6);
            $produit6->setParentCategorie($parentCategorie);


            $manager->persist($produit6);

            $produit7 = new Produit();

            $produit7->setLibelleProduit("Pearl");
            $produit7->setDescriptionProduit("Voici une batterie trop cool");
            $produit7->setPrixAchatHt("1049");
            $produit7->setPhoto("IMG/pearl.webp");
            $produit7->setPrix("1100");
            $produit7->setQuantiteStock("3");
            $produit7->setCategorie($categorie6);
            $produit7->setParentCategorie($parentCategorie);


            $manager->persist($produit7);


 // Ajout des produits aux catégories
        $categorie2->addProduit($produit1);
        $categorie2->addProduit($produit2);
        $categorie1->addProduit($produit3);
        $categorie3->addProduit($produit4);
        $categorie6->addProduit($produit5);
        $categorie6->addProduit($produit6);
        $categorie6->addProduit($produit7);


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
                            // empêcher l'auto incrément
            $metadata = $manager->getClassMetaData(Produit::class);
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);


        $manager->flush();
    }
}
