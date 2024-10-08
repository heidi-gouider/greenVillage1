<?php


namespace App\Controller;

use Stripe\StripeClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{

    private $manager;
    private $gateway;

    public function __construct(EntityManagerInterface $manager)
    {
    $this->manager = $manager;
    $this->gateway = new StripeClient ($_ENV['STRIPE_API_SECRET']);
    }



    #[Route('/checkout', name: 'app_checkout', methods: "POST")]
    public function checkout(Request $request): Response
    {
        // dd($request);
        $total=$request->request->get('total');
        $quantite=$request->request->get('quantite');

//  création du checkout

$checkout=$this->gateway->checkout->sessions->create(
    [
        'line_items'=>[[
            'price_data'=>[
                'currency'=>$_ENV['STRIPE_CURRENCY'],
                'product_data'=>[
                    'name'=>'Produit 1',
                ],
// attention a *100 si total en centimes
                'unit_amount'=>$total * 100,
            ],
            'quantity'=>$quantite,

        ]],
        'mode'=>'payment',
        'success_url'=>'https://127.0.0.1:8000/success',
        'cancel_url' => 'https://127.0.0.1:8000/cancel',
        ]);

        // dd($checkout);
        return $this->redirect($checkout->url);
        // Exemple de produits à acheter (ils peuvent venir de ton panier)
        // $products = [
        //     [
        //         'name' => 'Produit 1',
        //         'price' => 2000, // en centimes
        //         'quantity' => 1,
        //     ],
        //     [
        //         'name' => 'Produit 2',
        //         'price' => 1500,
        //         'quantity' => 2,
        //     ],
        // ];

        // Création de la session Stripe Checkout
        // $session = $stripeService->createCheckoutSession($products);

        // return $this->json(['id' => $session->id]);
        // return $this->render('stripe/checkout.html.twig', [
        //     'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY'],
        // ]);
    
    }

    #[Route('/success', name: 'app_success')]
    public function success(Request $request): Response
{
// récupérer les informations de l'utilisateur client

// Stocker dans la bdd

// envoyer un email

// message de succes
}
#[Route('/cancel', name: 'app_cancel')]
public function cancel(Request $request): Response
{
// récupérer les informations de l'utilisateur client

// Stocker dans la bdd

// envoyer un email

// message de succes
}

}
