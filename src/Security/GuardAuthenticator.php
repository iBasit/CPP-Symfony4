<?php

namespace App\Security;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

abstract class GuardAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = 'Invalid Credentials';
        if ($exception instanceof CustomUserMessageAuthenticationException) {
            $message = $exception->getMessageKey();
        }

        return new JsonResponse(['message' => $message], 401);
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        // noop
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // noop
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request)
    {
        return true;
    }
}