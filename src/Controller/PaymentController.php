<?php


namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository; 
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

    public function __construct(EntityManagerInterface $manager, CommandeRepository $commandeRepository)
    {
    $this->manager = $manager;
    $this->gateway = new StripeClient ($_ENV['STRIPE_API_SECRET']);
    $this->commandeRepository = $commandeRepository;
    }



    #[Route('/checkout', name: 'app_checkout', methods: "POST")]
    public function checkout(Request $request): Response
    {
        // dd($request);
        // Récupérer le total, la quantité et l'Id de la commande
        $total = $request->request->get('total');
        $quantite = $request->request->get('quantite');
        $commandeId = $request->request->get('commande_id');

    // dd($commandeId);

        // Vérifier que l'id commande à bien une valeur valide
    // if (empty($commandeId)) {
    //     throw new \Exception("Commande ID is missing.");
    // }

        $commande = $this->manager->getRepository(Commande::class)->find($commandeId);
    // dd($commande);

        if (!$commande) {
            throw $this->createNotFoundException('Commande introuvable.');
    }
    $lineItems = [];
foreach ($commande->getDetails() as $detail) {
    $produit = $detail->getProduit();

    $lineItems[] = [
        'price_data' => [
            'currency' => $_ENV['STRIPE_CURRENCY'],
            'product_data' => [
                'name' => $produit->getlibelleProduit(),  // Nom dynamique du produit
            // 'name'=>'Commande n°CMD' . $commande->getId(),

            ],
            // attention à *100 si les prix sont en centimes
            'unit_amount' => $produit->getPrix() * 100, 
        ],
        'quantity' => $detail->getQuantite(),
    ];
}
//  création de la session de paiement checkout
$checkout=$this->gateway->checkout->sessions->create(
    [
        'line_items' => $lineItems,
        'mode'=>'payment',
        'success_url'=>'https://127.0.0.1:8000/success?id_session={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'https://127.0.0.1:8000/cancel?id_session={CHECKOUT_SESSION_ID}',
        'metadata' => [
            'commande_id' => $commandeId,


        // 'line_items'=>[[
        //     'price_data'=>[
        //         'currency'=>$_ENV['STRIPE_CURRENCY'],
        //         'product_data'=>[
        //             'name'=>'Commande n°CMD'$commande->getId(),
        //         ],
// attention a *100 si total en centimes
        //         'unit_amount'=>$produit->getPrixAchatHt() * 100, 
        //     ],
        //     'quantity'=>$detail->getQuantite(),

        // ]],
        // 'mode'=>'payment',
        // 'success_url'=>'https://127.0.0.1:8000/success?id_session={CHECKOUT_SESSION_ID}',
        // 'cancel_url' => 'https://127.0.0.1:8000/cancel?id_session={CHECKOUT_SESSION_ID}',
        // 'metadata' => [
        //     'commande_id' => $commandeId,
        ]
        ]);

        // dd($checkout);
        return $this->redirect($checkout->url);
        
    }

    #[Route('/success', name: 'app_success')]
    public function success(Request $request): Response
{
    // dd($request);

    $id_session=$request->query->get('id_session');
    $commandeId = $request->query->get('commande_id');

    // Récupérer les détails de la session de paiement Stripe
    $session = $this->gateway->checkout->sessions->retrieve($id_session, []);

    // Vérifier si l'ID de la commande est présent
    // if (!$commandeId) {
    //     throw new \Exception("Commande ID is missing in the success URL.");
    // }

     // Vérifier que les métadonnées contiennent bien l'ID de la commande
    if (!isset($session->metadata['commande_id'])) {
        throw $this->createNotFoundException('ID de commande non trouvé dans les métadonnées Stripe.');
    }
// Récupérer l'ID de la commande à partir des métadonnées
$commandeId = $session->metadata['commande_id'];

        // Récupérer la commande correspondante par l'Id
    $commande = $this->manager->getRepository(Commande::class)->find($commandeId);
    if (!$commande) {
        throw $this->createNotFoundException('Commande introuvable.');
    }

 // Récupérer les détails de la session de paiement Stripe
 $userClient=$this->gateway->checkout->sessions->retrieve($id_session,[]);
// Récupérer les informations de paiement
$paymentStatus = $userClient['payment_status'];
    // dd($commandeId);

// récupérer les informations de la transaction
$name=$userClient["customer_details"]["name"];
$email=$userClient["customer_details"]["email"];
$paymentStatus=$userClient["customer_details"]["payment_status"];
$amount=$userClient["amount_total"];
$paymentType=$userClient["payment_method_types"];
// Récupérer les informations de paiement
$paymentStatus = $session['payment_status'];
$amount = $session['amount_total'];
// Mettre à jour la commande avec les informations de paiement
if ($paymentStatus === 'paid') {
    $commande->setStatus(true); // Mise à jour du statut de paiement
    $commande->setEtat(Commande::ETAT_ENREGISTREE_PAYEE);  // Utiliser la constante pour "Payé"
    // $commande->setStatus(Commande::STATUT_PAYE);
    $commande->setDateReglement(new \DateTime());
  //   $commande->setMontantTotal($userClient['amount_total'] / 100);
    // $commande->setMontantTotal($session->amount_total / 100);
    $commande->setTotalHt($amount / 100);

// Mettre à jour la quantité des produits
foreach ($commande->getDetails() as $detail) {
    $detail->setQuantite($detail->getQuantite()); // Assurez-vous de définir la quantité ici
    $this->manager->persist($detail); // Persister chaque détail
}
} else {
    // Gérer le cas où le paiement n'a pas réussi
    $commande->setEtat(Commande::ETAT_EN_ERREUR);
    // $this->manager->persist($commande);
    // $this->manager->flush();
}

      // Mettre à jour l'état de la commande et enregistrer les détails du paiement
    //   Vérifier si le paiement a été effectué
    //   $commande->setEtat(0);  // Par exemple, 0 pourrait signifier "Payé"


// Sauvegarder les informations de paiement dans la base de données
$this->manager->persist($commande);
$this->manager->flush();



// Récupérer les informations du client
$name = $session['customer_details']['name'];
$email = $session['customer_details']['email'];


// dd($userClient);


// Stocker dans la bdd



// envoyer un email



// message de succes
return $this->render('stripe/success.html.twig',[
    'name'=>$name,
    'commande' => $commande,
    'commande_id' => $commandeId,
    'details' => $commande->getDetails(),
]);


}
#[Route('/cancel', name: 'app_cancel')]
public function cancel(Request $request): Response
{
    dd("cancel");
}

}
