<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Security;

class AppAutenticatorAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private $userProvider;

    public function __construct(private UrlGeneratorInterface $urlGenerator, UserProviderInterface $userProvider)
    {
        $this->urlGenerator = $urlGenerator;
        $this->userProvider = $userProvider;
        // $this->adminProvider = $adminProvider;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->getPayload()->getString('email');
        // $email = $request->request->get('email');
        //
        $password = $request->get('password');
        // $password = $request->request->get('password');
        $csrfToken = $request->get('_csrf_token');
        //
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

         // Récupérer l'utilisateur à partir de l'email pour vérifier le statut de vérification
        // $userBadge = new UserBadge($email, function ($userIdentifier) {
        $user = $this->userProvider->loadUserByIdentifier($email);

        if (!$user) {
            error_log('User not found: ' . $email);
            throw new CustomUserMessageAuthenticationException('Utilisateur non trouvé.');
        }

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // error_log('isVerified: ' . var_export($token->getUser()->isVerified(), true));
        // on verifie qu'il a validé son email
        // if(!$token->getUser()->isVerified()){
        //     $request->getSession()->set(Security::AUTHENTICATION_ERROR, "You are not verified. Check your emails.");
        // }

         // Si l'utilisateur a vérifié son e-mail, continuez normalement
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
         // sinon, on l'envoie sur la page `profil`
         return new RedirectResponse($this->urlGenerator->generate('app_accueil'));

        // For example:
        //  return new RedirectResponse($this->urlGenerator->generate('app_route'));
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    
    }
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE); 
    }
}
