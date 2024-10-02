<?php

namespace App\Service;

use App\Entity\Produit;
use Stripe\StripeClient;
use Stripe\Price;

class StripeService
{
    private StripeClient $stripe;

    public function createProduit(Produit $produit): \Stripe\Produit
    {
        return $this->stripe->products->create([
            'libelle' => $produit->getLibelleProduit(),
            'description' => $produit->getDescriptionProduit(),
        ]);
    }

    public function createPrix(Produit $produit): Price
    {
        return $this->stripe->prices->create([
            'unit_amount' => $produit->getPrix(),
            'currency' => 'EUR',
            'produit' => $produit->getStripeProduitId()
        ]);
    }

    private function getStripe()
    {
        return $this->stripe ??= new StripeClient($_ENV('STRIPE_SECRET'));
    }
}