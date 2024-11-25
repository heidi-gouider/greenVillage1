<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        $utilisateur = $this->getUser();
        // Si l'utilisateur est connecté, vérifier son statut de vérification
        if ($utilisateur && $utilisateur instanceof \App\Entity\Utilisateur && !$utilisateur->isVerified()) {
            // if ($this->getUser() && !$this->getUser()->isVerified()) {
            $this->addFlash('error', 'Vous devez vérifier votre e-mail avant de vous connecter.');
        return $this->redirectToRoute('app_logout');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last email entered by the user
        $email = $authenticationUtils->getLastUsername();
        // $email = $authenticationUtils->getLastEmail();

        return $this->render('security/login.html.twig', [
            'last_email' => $email,
            'error' => $error
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
