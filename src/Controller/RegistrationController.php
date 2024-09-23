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
            // $existingUser = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($existingUser) {
                $this->addFlash('warning', 'Vous avez déjà un compte. Veuillez vous connecter.');
                return $this->redirectToRoute('app_login'); // Rediriger vers la page de connexion
            }
                        // encode the plain password
            $utilisateur->setPassword(
                $userPasswordHasher->hashPassword(
                    $utilisateur,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $utilisateur,
                (new TemplatedEmail())
                    ->from(new Address('support@demo.fr', 'Support'))
                    ->to($utilisateur->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email
                 return $this->redirectToRoute('app_accueil');
                //  return $this->redirectToRoute('app_profil');
                // }

            return $security->login($utilisateur, AppAutenticatorAuthenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
// désactivé en prod 
    // #[Route('/verify/email', name: 'app_verify_email')]
    // public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        // try {
        //     $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        // } catch (VerifyEmailExceptionInterface $exception) {
        //     $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

        //     return $this->redirectToRoute('app_register');
        // }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
    //     $this->addFlash('success', 'Your email address has been verified.');

    //     return $this->redirectToRoute('app_register');
    // }
}
