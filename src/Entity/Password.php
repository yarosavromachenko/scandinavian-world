<?php

namespace App\Entity;

use App\Repository\PasswordRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PasswordRepository::class)]
#[ORM\Table(name: 'password')]
#[ORM\Index(name: 'unique_idx', columns: ['password', 'length'])]
class Password
{
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(name: 'password', type: Types::STRING, unique: true)]
    private string $password;

    #[ORM\Column(name: 'length', type: Types::INTEGER)]
    private int $length;

    #[ORM\Column(name: "created_at", type: Types::DATETIME_MUTABLE)]
    protected ?DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
