<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateurRepository;
use App\Security\AppAutenticatorAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepo): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $utilisateur->getEmail();


            // Vérifier si l'utilisateur existe déjà avec cet e-mail
            $existingUser = $utilisateurRepo->findOneBy(['email' => $email]);

            if ($existingUser) {
                $this->addFlash('warning', 'Vous avez déjà un compte. Veuillez vous connecter.');
                return $this->redirectToRoute('app_login'); // Rediriger vers la page de connexion
            }

            // Hashage du mot de passe
            $utilisateur->setPassword(
                $userPasswordHasher->hashPassword(
                    $utilisateur,
                    $form->get('password')->getData()
                    // ['first']
                )
            );


        // Par défaut, l'utilisateur n'est pas vérifié
        // $utilisateur->setVerified(false);

          // Persist and flush the nouvel utilisateur
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            // Envoyer le e-mail de confirmation
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $utilisateur,
                (new TemplatedEmail())
                    ->from(new Address('support@demo.fr', 'Support'))
                    ->to($utilisateur->getEmail())
                    ->subject('Veuillez confirmer votre Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            $this->addFlash('success', 'Un e-mail de confirmation a été envoyé. Veuillez vérifier votre boîte de réception.');

            // On vérifie qu'on a bien un user et qu'il n'est pas déjà activé
            // if($utilisateur && !$utilisateur->isVerified()){
            // Une fois l'email vérifié, on met à jour l'utilisateur
        // $utilisateur = $this->getUser();
        // $utilisateur->setVerified(true);
        // $em->persist($utilisateur);
        // $em->flush();
            // };
// voir pour comentaire
// return $security->login($utilisateur, AppAutenticatorAuthenticator::class, 'main');

            // Redirection après l'inscription
            return $this->redirectToRoute('app_login');

            // Ne pas authentifier l'utilisateur immédiatement, on attend la vérification de l'email
// authentification immédiate après inscription
            // return $security->login($utilisateur, AppAutenticatorAuthenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

// désactivé en prod 
    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator,  EntityManagerInterface $em ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
            $this->addFlash('success', 'Votre e-mail a bien été vérifié.');

        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }
                // @TODO Change the redirect on success and handle or remove the flash message in your templates
                // $this->addFlash('success', 'Votre E-mail a bien été vérifié.');


        return $this->redirectToRoute('app_accueil');
        // return $this->redirectToRoute('app_register');

    }
}
