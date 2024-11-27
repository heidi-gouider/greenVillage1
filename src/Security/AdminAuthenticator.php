<?php

namespace App\Security;

use App\Repository\AdminRepository; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
// use Symfony\Component\Security\Core\User\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AdminAuthenticator extends AbstractAuthenticator
{
    private UserProviderInterface $adminProvider;

    public function __construct(UserProviderInterface $adminProvider)
    {
        $this->adminProvider = $adminProvider;
    }

    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/login/admin' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');
        $password = $request->request->get('password', '');

        if (empty($username) || empty($password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return new SelfValidatingPassport(
            new UserBadge($username, function ($userIdentifier) {
                return $this->adminProvider->loadUserByIdentifier($userIdentifier);
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse('/admin'); 
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse('/login/admin?error=1');
    }
}
