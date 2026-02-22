<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Enum\NoticeEnum;
use App\Form\RegistrationFormType;
use App\Service\Auth\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth')]
class AuthController extends AbstractController
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    /**
     * Render register form
     */
    #[Route('/register', name: 'app_auth_register', methods: ['GET', 'POST'])]
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->authService->register($user, $form->get('password')->getData());

            if (empty($user)) {
                $this->addFlash(NoticeEnum::ERROR->value, 'An error occurred while creating your account. Please try again later.');

                return $this->redirectToRoute('app_auth_register');
            }

            $this->addFlash(NoticeEnum::SUCCESS->value, 'Your account has been created successfully. You can now log in.');

            return $this->redirectToRoute('app_info_home');
        }

        return $this->render('/pages/auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Render login form
     */
    #[Route('/login', name: 'app_auth_login', methods: ['GET'])]
    public function login(Request $request)
    {
        return $this->render('/pages/auth/login.html.twig');
    }
}
