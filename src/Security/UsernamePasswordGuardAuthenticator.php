<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


final class UsernamePasswordGuardAuthenticator extends GuardAuthenticator
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if (!$request->isMethod('POST')) {
            throw new MethodNotAllowedHttpException(['POST']);
        }

        return [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];

        if (!$this->passwordEncoder->isPasswordValid($user, $plainPassword)) {
            throw new BadCredentialsException();
        }

        return true;
    }
}