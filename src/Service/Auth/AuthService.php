<?php

namespace App\Service\Auth;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\Enum\UserRoles;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly Security $security,
    ) {}

    /**
     * Register a new user. Returns the authenticated user if registration is successful, otherwise returns null.
     */
    public function register(User $user, string $plainPassword): ?Response
    {
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $plainPassword)
        );
        $user->setRole(UserRoles::USER->value);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->logger->info('User registered successfully: ' . $user->getEmail());

            return $this->security->login($user, 'App\Security\LoginAuthenticator', 'main');
        } catch (\Throwable $th) {
            $this->logger->error('Error while registering user: ' . $th->getMessage(), ['exception' => $th]);

            return null;
        }

        return null;
    }

    /**
     * Search for a user by email and password. Returns the user if found and password is valid, otherwise returns null.
     */
    public function searchUserByCredentials(string $email, string $plainPassword): ?User
    {
        $foundUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$foundUser) {
            return null;
        }

        if (!$this->passwordHasher->isPasswordValid($foundUser, $plainPassword)) {
            return null;
        }

        $this->security->login($foundUser, 'App\Security\LoginAuthenticator', 'main');

        return $foundUser;
    }
}
