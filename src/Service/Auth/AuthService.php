<?php

namespace App\Service\Auth;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\Enum\UserRoles;

class AuthService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger,
    ) {}

    public function register(User $user, string $plainPassword): ?User
    {
        $user->setPassword(password_hash($plainPassword, PASSWORD_ARGON2ID));
        $user->setRole(UserRoles::USER->value);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Throwable $th) {
            $this->logger->error('Error while registering user: ' . $th->getMessage());

            return null;
        }

        return $user;
    }
}
