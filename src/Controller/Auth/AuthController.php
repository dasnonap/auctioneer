<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth')]
class AuthController extends AbstractController
{
    public function __construct() {}

    /**
     * Render register form
     */
    #[Route('/register', name: 'app_auth_register', methods: ['GET'])]
    public function register(Request $request)
    {
        dd('aloha');
    }


    /**
     * Render login form
     */
    #[Route('/login', name: 'app_auth_login', methods: ['GET'])]
    public function login(Request $request)
    {
        dd('yesss sirtski');
    }

    /**
     * Authorize user
     */
    #[Route('/api/authorize', name: 'api_auth', methods: ['POST'])]
    public function auth(Request $request)
    {
        dd('aaaaaaaa');
    }
}
