<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Exception\InvalidJWTException;
use App\Service\JWTCoder;


final class JWTGuardAuthenticator extends GuardAuthenticator
{
    private $jwtCoder;

    public function __construct(JWTCoder $jwtCoder)
    {
        $this->jwtCoder = $jwtCoder;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if (!$request->headers->has('Authorization')) {
            throw new CustomUserMessageAuthenticationException('Missing Authorization Header');
        }
        $headerParts = explode(' ', $request->headers->get('Authorization'));
        if (!(count($headerParts) === 2 && $headerParts[0] === 'Bearer')) {
            throw new CustomUserMessageAuthenticationException('Malformed Authorization Header');
        }

        return $headerParts[1];
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $payload = $this->jwtCoder->decode($credentials);
        } catch (InvalidJWTException $e) {
            throw new CustomUserMessageAuthenticationException($e->getMessage());
        } catch (\Exception $e) {
            throw new CustomUserMessageAuthenticationException('Malformed JWT');
        }
        if (!isset($payload['username'])) {
            throw new CustomUserMessageAuthenticationException('Invalid JWT');
        }

        return $userProvider->loadUserByUsername($payload['username']);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }
}