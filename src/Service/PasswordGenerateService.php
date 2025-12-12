<?php

namespace App\Service;

use App\Dto\GeneratePasswordDTO;

class PasswordGenerateService
{
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

        $passwordLength = $generatePasswordDTO->getPasswordLength();
        $allChars = array_merge(...array_values($selectedCharacters));
        $uniqueCount = count($allChars);

        if ($passwordLength > $uniqueCount) {
            return 'Password length too long for unique characters!';
        }

        $password = [];

        foreach ($selectedCharacters as $type => $values) {
            $index = array_rand($values);
            $password[] = $values[$index];
            unset($values[$index]);
            $selectedCharacters[$type] = $values;
        }

        $remainingChars = array_merge(...array_values($selectedCharacters));

        while (count($password) < $passwordLength) {
            $index = array_rand($remainingChars);
            $password[] = $remainingChars[$index];
            unset($remainingChars[$index]);
            $remainingChars = array_values($remainingChars);
        }

        return implode('', $password);
    }
}
