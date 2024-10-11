<?php

namespace App\Controller;

use App\Entity\Commande; 
use App\Entity\Detail; 
use App\Entity\Utilisateur;
use App\Repository\ProduitRepository;
use App\Repository\DetailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande', name: 'app_commande_')]
class CommandeController extends AbstractController
{
    #[isGranted('ROLE_USER', message: "Vous devez avoir un compte pour accèder à cette page!")]

    #[Route('/ajout', name: 'ajout')]
    public function ajout(SessionInterface $session, ProduitRepository $produitRepository, EntityManagerInterface $em): Response
    {
        // restriction accès 
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        // if($panier === []){
        //     $this->addFlash('message', 'Votre panier est vide');
        //     return $this->redirectToRoute('app_categorie');
        // }
  //Le panier n'est pas vide, on crée la commande
  $commande = new Commande();
  $commande->setUtilisateur($this->getUser());
    $commande->setDateCommande(new \DateTime());

// Etat et status initial
  $commande->setEtat(0); 
  $commande->setStatus(0); 

  $total = 0;

  // On parcourt le panier pour créer les détails de commande
  foreach($panier as $item => $quantite){
      $detail = new Detail();
      // On va chercher le produit
      $produit = $produitRepository->find($item);

    //   $prix = $produit->getPrixAchatHt();
      $prix = $produit->getPrix();

      // On crée le détail de commande
      $detail->setProduit($produit);
    //   $detail->setTotal($prix);
      $detail->setQuantite($quantite);
      $commande->addDetail($detail);

      $total += $prix * $quantite;

       // Persist chaque detail
       $em->persist($detail);
  }

  $commande->setTotalHt($total);
//   $commandes = $utilisateur->getCommandes();

// Optionnel : définir le mode de règlement et la date de règlement si nécessaire
$commande->setModeReglement('Stripe'); // Exemple : mode de paiement
// $commande->setDateReglement(new \DateTime()); // À définir selon l'état du paiement

  // On persiste et on flush
  $em->persist($commande);
  $em->flush();

  $session->remove('panier');

  $this->addFlash('message', 'Commande créée avec succès');
//   return $this->redirectToRoute('app_accueil');
return $this->redirectToRoute('app_commande_show', ['id' => $commande->getId()]);
        // return $this->render('commande/index.html.twig', [
        //     'commandes' => $commande,
        //     'details' => $detail
        // ]);
    }
    
// je récupere l'historique de commande de l'utilisateur
// pour l'afficher via le lien dans la vue du panier

#[Route('/panier/commandes', name: 'panier_commandes')]

    public function index(UserInterface $user)
    {

    if (!$user instanceof Utilisateur) {
        throw new \Exception('User must be an instance of App\Entity\Utilisateur');
    }
        $commandes = $user->getCommandes();

 // Préparer les commandes avec leur libellé d'état
 $commandesWithEtatLibelle = [];
 foreach ($commandes as $commande) {
     $commandesWithEtatLibelle[] = [
         'commande' => $commande,
        //  'etat_libelle' => \App\Entity\Commande::getEtatLibelle($commande->getEtat()),
     ];

        return $this->render('panier/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
    // Définition de la méthode generateUniqueReference
    // private function generateUniqueReference(): int
    // {
        // Utilisez le timestamp actuel en secondes
        // $timestamp = time();
        // Ajouter une composante aléatoire pour garantir l'unicité
        // $randomComponent = random_int(1000, 9999);

        // Combinez les deux pour obtenir une référence unique
        // $reference = (int) ($timestamp . $randomComponent);

        // return $reference;
    // }

     #[Route('/commande/{id}', name : 'show')]
     
     public function show(Commande $commande): Response
    {
        // Vérifier si l'utilisateur est bien le propriétaire de la commande
    if ($commande->getUtilisateur() !== $this->getUser()) {
        throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à voir cette commande.');
    }

    $totalCom = 0;
    $total = 0;
    $quantiteTotal = 0;

        // $etat = $commande->getEtat();
        // $etatLibelle = Commande::getEtatLibelle($etat);
    foreach ($commande as $commande) {
            $totalCom += $commande->getTotalHt();  // 'getTotalHt' retourne le total de la commande
        }
        // Récupérer les détails de la commande
    $details = $commande->getDetails();

        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
            // 'etat_libelle' => $etatLibelle,
            'details' => $details,
            'total' => $total,
            'quantiteTotal' => $quantiteTotal,
            'total' => $totalCom,
        ]);
    }


    // je recupère la méthode et le query builder du repo detail 
    // #[Route('/top_discs', name: 'top_discs')]
    #[Route('/', name: 'top_produits')]
private $detailRepo;
public function __construct(DetailRepository $detailRepo)
{
    $this->detailRepo = $detailRepo;
}
    public function topProduits(): Response
    {
    
        // j'utilise la méthode créer dans le repo findByTopVente()
        // $topProduits = $this->detailRepo->findByTopVente();

        // je passe le résultat à ma vue
        return $this->render('accueil/index.html.twig', [
            // 'topProduits' => $topProduits,
        ]);
    }

}
