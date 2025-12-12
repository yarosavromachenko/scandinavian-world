<?php

namespace App\Service;

use App\Dto\GeneratePasswordDTO;
use App\Manager\PasswordManager;
use App\Repository\PasswordRepository;

class PasswordGenerateService
{
    public function __construct(
        private readonly PasswordRepository $passwordRepository,
        private readonly PasswordManager $passwordManager,
    ) {
    }

    public function generatePassword(GeneratePasswordDTO $generatePasswordDTO): string
    {
        $selectedCharacters = [];
        if ($generatePasswordDTO->isNumbers()) {
            $selectedCharacters['numbers'] = range(0, 9);
        }
        if ($generatePasswordDTO->isLowercase()) {
            $selectedCharacters['lowercase'] = range('a', 'z');
        }
        if ($generatePasswordDTO->isUppercase()) {
            $selectedCharacters['uppercase'] = range('A', 'Z');
        }

        if (empty($selectedCharacters)) {
            return 'Please select at least one character type!';
        }

        $length = $generatePasswordDTO->getPasswordLength();
        $allChars = array_merge(...array_values($selectedCharacters));
        $uniqueCount = count($allChars);

        if ($length > $uniqueCount) {
            return 'Password length too long for unique characters!';
        }

        do {
            $password = $this->generateUniquePassword($selectedCharacters, $length);
        } while (!$this->checkUniquenessAndStore($password, $length));

        return $password;
    }

    private function generateUniquePassword(array $selectedCharacters, int $length): string
    {
        $password = [];

        foreach ($selectedCharacters as $type => $values) {
            $index = array_rand($values);
            $password[] = $values[$index];

            unset($values[$index]);
            $selectedCharacters[$type] = array_values($values);
        }

        $remainingChars = array_merge(...array_values($selectedCharacters));

        while (count($password) < $length) {
            $index = array_rand($remainingChars);
            $password[] = $remainingChars[$index];
            unset($remainingChars[$index]);
            $remainingChars = array_values($remainingChars);
        }

        return implode('', $password);
    }
    private function checkUniquenessAndStore(string $password, int $length): bool
    {
        if ($this->passwordRepository->findOneBy(['password' => $password, 'length' => $length])) {
            return false;
        }

        $this->passwordManager->add($password, $length);

        return true;
    }
}
