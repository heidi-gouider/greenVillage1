<?php

namespace App\Security;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function sendEmailConfirmation(string $verifyEmailRouteName, Utilisateur $utilisateur, TemplatedEmail $email): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            (string) $utilisateur->getId(),
            $utilisateur->getEmail()
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, Utilisateur $utilisateur): void
    {
        $this->verifyEmailHelper->validateEmailConfirmationFromRequest($request, (string) $utilisateur->getId(), $utilisateur->getEmail());

        $utilisateur->setVerified(true);

        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
    }
}
