<?php

namespace App\Manager;

use App\Entity\Password;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class PasswordManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function add(string $password, int $length): void
    {
        $passwordObject = new Password();
        $passwordObject->setPassword($password);
        $passwordObject->setLength($length);
        $passwordObject->setCreatedAt(new DateTime());

        $this->entityManager->persist($passwordObject);
        $this->entityManager->flush();
    }
}
