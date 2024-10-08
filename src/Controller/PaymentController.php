<?php


namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/checkout', name: 'checkout')]
    public function checkout(StripeService $stripeService): JsonResponse
    {
        // Exemple de produits à acheter (ils peuvent venir de ton panier)
        $products = [
            [
                'name' => 'Produit 1',
                'price' => 2000, // en centimes
                'quantity' => 1,
            ],
            [
                'name' => 'Produit 2',
                'price' => 1500,
                'quantity' => 2,
            ],
        ];

        // Création de la session Stripe Checkout
        $session = $stripeService->createCheckoutSession($products);

        return $this->json(['id' => $session->id]);
        return $this->render('stripe/checkout.html.twig', [
            'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY'],
        ]);
    
    }
    
}
