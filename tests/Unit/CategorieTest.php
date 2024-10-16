<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Categorie;

class CategorieTest extends KernelTestCase
{
    // pour éviter les redondances
    public function getEntity() : Categorie
    {
        return (new Categorie())
        ->setLibelleCategorie('vue');
    }
    public function testEntiyIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $categorie = $this->getEntity();
        // $categorie = new Categorie;
        // $this->assertInstanceOf(Categorie::class, $categorie);
        // $categorie->setLibelleCategorie('guitarre');
        $errors = $container->get('validator')->validate($categorie);
        $this->assertCount(0, $errors);
        // $this->assertSame('test', $kernel->getEnvironment());
    }

    public function testInvalideLibelle()
    {
        self::bootKernel();
        $container = static::getContainer();

        $categorie = $this->getEntity();

        // $categorie = new Categorie;
        // $this->assertInstanceOf(Categorie::class, $categorie);
        $categorie->setLibelleCategorie('');

        $errors = $container->get('validator')->validate($categorie);
        $this->assertCount(0, $errors);

    }
}
