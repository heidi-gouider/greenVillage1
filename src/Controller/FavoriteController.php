<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite')]
    public function index(FavoriteRepository $favoriteRepository, AuthenticationUtils $authenticationUtils): Response
    {
          // Récupérer l'utilisateur connecté
          $user = $this->getUser();
          if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour voir vos favoris.');
            return $this->redirectToRoute('app_login');
        }

        // $Utilisateur = $this->getUtilisateur();
        $favorites = $favoriteRepository->findBy(['utilisateur' => $user]);

        // pour la modal login admin
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
            

        return $this->render('favorite/index.html.twig', [
            'favorites' => $favorites,
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/favorites/add/{id}', name: 'add_to_favorites')]
    public function addToFavorites(Produit $product, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$this->getUser()) {
            $this->addFlash('error', 'Vous devez être connecté pour ajouter un favori.');
            return $this->redirectToRoute('app_login'); // ou une autre route
        }        

        // Vérifier si le produit est déjà en favori
        $existingFavorite = $em->getRepository(Favorite::class)->findOneBy([
            'utilisateur' => $user,
            'produit' => $product,
        ]);

        if ($existingFavorite) {
            $this->addFlash('info', 'Ce produit est déjà dans vos favoris.');
            // return $this->redirectToRoute('produit_show', ['id' => $product->getId()]);
        }

        $favorite = new Favorite();
        $favorite->setUtilisateur($user);
        $favorite->setProduit($product);

        $em->persist($favorite);
        $em->flush();

        // return new JsonResponse(['status' => 'success', 'message' => 'Produit ajouté aux favoris !']);

        $this->addFlash('success', 'Produit ajouté aux favoris !');
        // Reste sur la page du produit actuel
        return $this->redirectToRoute('app_detail_produit', ['id' => $product->getId()]);
        // return $this->redirectToRoute('produit_show', ['id' => $product->getId()]);

        // return $this->render('produit/show.html.twig', [
        //     'produit' => $product,
        // ]);
    }

    #[Route('/favorites/remove/{id}', name: 'remove_from_favorites')]
    public function removeFromFavorites(Produit $product, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $favorite = $em->getRepository(Favorite::class)->findOneBy([
            'utilisateur' => $user,
            'produit' => $product,
        ]);

        if ($favorite) {
            $em->remove($favorite);
            $em->flush();

            $this->addFlash('success', 'Produit retiré des favoris.');
        } else {
            $this->addFlash('error', 'Ce produit n\'est pas dans vos favoris.');
        }

        // return $this->redirectToRoute('app_detail_produit', ['id' => $product->getId()]);
        return $this->redirectToRoute('app_favorite');
    }

    // #[Route('/favorites', name: 'favorites_list')]
    // public function listFavorites(FavoriteRepository $favoriteRepository): Response
    // {
    //     $Utilisateur = $this->getUtilisateur();
    //     $favorites = $favoriteRepository->findBy(['user' => $user]);

    //     return $this->render('favorites/list.html.twig', [
    //         'favorites' => $favorites,
    //     ]);
    // }
}
