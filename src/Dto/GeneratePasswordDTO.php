<?php

declare(strict_types=1);

namespace App\Dto;

class GeneratePasswordDTO
{
    public function __construct(
        private readonly int $passwordLength,
        private readonly bool $numbers,
        private readonly bool $lowercase,
        private readonly bool $uppercase,
    ) {
    }

    public function getPasswordLength(): int
    {
        return $this->passwordLength;
    }

    public function isNumbers(): bool
    {
        return $this->numbers;
    }

    public function isLowercase(): bool
    {
        return $this->lowercase;
    }

    public function isUppercase(): bool
    {
        return $this->uppercase;
    }
}
