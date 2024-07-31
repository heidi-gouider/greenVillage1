<?php

namespace App\Controller;

use App\Entity\Commande; 
use App\Entity\Utilisateur;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande')]
    public function index(SessionInterface $session, Request $request, ProduitRepository $produitRepository)
    {
        // j'initialise les variables
        $commande = $session->get('commande', []);
        // Pour permettre à l'utilisateur de revenir sur la dernière page visitée
        $referer = $request->headers->get('referer');
        $data = [];
        $total = 0;

        foreach ($commande as $id => $quantite) {
            $produit = $produitRepository->find($id);
            $data[] = [
                'produit' => $produit,
                'quantite_produit' => $quantite
            ];
            $total += $produit->getPrixAchatHt() * $quantite;
        }
        return $this->render('commande/index.html.twig', [
            'data' => $data,
            'total' => $total
        ]);        
    }
        // ***Ajout à la commande***
        #[Route('/commande/ajout/{id}', name: 'commande_ajout')]
        public function add(Produit $produit, SessionInterface $session, Request $request)
        {
    // dd($session);
    // Récupérer la quantité depuis la requête ou utiliser une valeur par défaut
            $quantite = $request->request->get('quantite_produit', 1);
            $action = $request->request->get('action');

            if ($action === 'increment') {
                $quantite++;
            } elseif ($action === 'decrement' && $quantite > 1) {
                $quantite--;
            }
    
    
            $form = $this->createFormBuilder()
                ->add('quantite_produit', IntegerType::class, [
                    'attr' => ['min' => 1, 'max' => 10],
                    // Définis les valeurs minimales et maximales
                ])
                ->getForm();
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $quantite = $form->get('quantite_produit')->getData();
                // Traitement des données, y compris la quantité choisie
            }
            // récuperer l'id du produit
            $id = $produit->getId();

            // Obtenez le panier existant à partir de la session ou créez-en un nouveau.
            $commande = $session->get('commande', []);
    
            // Ajoutez ou mettez à jour la quantité du produit dans le panier.
            $commande[$produit->getId()] = $quantite;
    
            // Enregistrez le panier mis à jour dans la session.
            $session->set('commande', $commande);
            return $this->redirectToRoute('commande');
     // Récupérez l'URL de la page actuelle et stockez-la dans la session.
     $referer = $request->headers->get('referer');
     $session->set('referer_url', $referer);

     // Redirigez l'utilisateur vers la page précédente.
     // return $this->redirect($referer);        
     return $this->render('commande/index.html.twig', [
         'controller_name' => 'CommandeController',
     ]);

}
// #[Route('/commande/ajout/{id}', name: 'commande_ajout')]
// public function ajout(Produit $produit, SessionInterface $session)
// {
//     $id = $produit->getId();
//     $commande = $session->get('commande', []);

//     if (empty($commande[$id])) {
//         $commande[$id] = 1;
//     } else {
//         $commande[$id]++;
//     }
    
//     $session->set('commande', $commande);

    // return $this->render('commande/index.html.twig')
    // return $this->redirectToRoute('commande');
    // return $this->redirectToRoute('commande_index');
    // return $this->render('commande/index.html.twig', [
    //     'controller_name' => 'CommandeController',
    // ]);




#[Route('/retirer/{id}', name: 'commande_retirer')]
public function retirer(Produit $produit, SessionInterface $session)
{

    // récuperer l'id du produit
    $id = $produit->getId();
    // Obtenez le panier existant à partir de la session ou créez-en un nouveau.
    $commande = $session->get('commande', []);
    // app_commande_ajoutco
    //     unset($panier[$id]);
    if (!empty($commande[$id])) {
        if ($commande[$id] > 1)
            $commande[$id]--;
    } else {
        unset($commande[$id]);
    }
    
    // Enregistrez le panier mis à jour dans la session.
    $session->set('commande', $commande);


    return $this->redirectToRoute('commande');
}

#[Route('/supprimer/{id}', name: 'commande_supprimer')]
public function supprimer(Produit $produit, SessionInterface $session)
{
    $id = $produit->getId();
    $commande = $session->get('commande', []);

    if (!empty($panier[$id])) {
        // si le panier est vide de défais la variable
        unset($commande[$id]);
    }
    $session->set('commande', $commande);


    return $this->redirectToRoute('commande');
// return $this->render('panier/index.html.twig', [
//     'controller_name' => 'PanierController',
// ]);
}
#[Route('/valider', name: 'valider')]
public function valider(SessionInterface $session, EntityManagerInterface $em)
{
    $panier = $session->get('panier', []);
    if (empty($panier)) {
        return $this->redirectToRoute('panier_index');
    }

    $user = $this->getUser();

    $commande = new Commande();
    $commande->setUser($user);
    $commande->setDateCommande(new \DateTime());
    $commande->setEtat('1');

    $total = 0;
    foreach ($commande as $id => $quantite) {
        $produit = $em->getRepository(Produit::class)->find($id);
        $detail = new Detail();
        $detail->setCommande($commande);
        $detail->setProduit($produit);
        $detail->setQuantiteProduit($quantite);

        $em->persist($detail);

        $total += $produit->getPrixAchatHt() * $quantite;
    }

    $commande->setTotal($total);

    $em->persist($commande);
    $em->flush();

    $session->remove('commande');

    $this->addFlash('success', 'Votre commande a bien été envoyée.');

    return $this->redirectToRoute('commande_detail', ['id' => $commande->getId()]);
}
#[Route('/commande/{id}', name: 'commande_detail')]
    public function commandeDetail(Commande $commande)
    {
        return $this->render('commande/index.html.twig', [
            'commande' => $commande,
        ]);
}}
