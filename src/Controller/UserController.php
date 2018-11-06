<?php

namespace App\Controller;

use App\Service\JWTCoder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * NOTE: I don't return a response in the UsernamePasswordGuardAuthenticator
     *       because I wanted a controller to do the rendering. You could always
     *       return a JsonResponse in UsernamePasswordGuardAuthenticator::onAuthenticationSuccess().
     *       If you do that, this class/method is no longer required.
     */
    public function loginAction()
    {
        $token = $this->get(JWTCoder::class)->encode([
            'username' => $this->getUser()->getUsername(),
        ]);

        return new JsonResponse(['token' => $token]);
    }
}