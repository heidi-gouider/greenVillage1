<?php

namespace App\Service;

use App\Entity\Produit;
use Stripe\StripeClient;
use Stripe\Price;

class StripeService
{
    private StripeClient $stripe;

    public function __construct(string $stripeSecretKey)
    {
        // Initialiser le StripeClient avec la clé secrète
        $this->stripe = new StripeClient($stripeSecretKey);
    }

    /**
     * Crée un produit Stripe basé sur l'entité Produit
     */
    public function createProduit(Produit $produit): \Stripe\Produit
    {
        return $this->stripe->products->create([
            'name' => $produit->getLibelleProduit(),
            'description' => $produit->getDescriptionProduit(),
        ]);
    }

     /**
     * Crée un prix Stripe pour le produit
     */
    public function createPrix(Produit $produit): Price
    {
        return $this->stripe->prices->create([
            'unit_amount' => $produit->getPrix() * 100, //le prix est en centimes
            'currency' => 'EUR',
            'product' => $produit->getStripeProduitId()
        ]);
    }

    private function getStripe()
    {
        return $this->stripe ??= new StripeClient($_ENV('STRIPE_SECRET'));
    }
}