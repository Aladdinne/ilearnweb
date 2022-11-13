<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idmessage = null;

    #[ORM\Column]
    private ?int $idemetteur = null;

    #[ORM\Column]
    private ?int $idroom = null;

    #[ORM\Column(length: 150)]
    private ?string $message = null;

    public function getIdmessage(): ?int
    {
        return $this->idmessage;
    }

    public function getIdemetteur(): ?int
    {
        return $this->idemetteur;
    }

    public function setIdemetteur(?int $idemetteur): self
    {
        $this->idemetteur = $idemetteur;

        return $this;
    }

    public function getIdroom(): ?int
    {
        return $this->idroom;
    }

    public function setIdroom(?int $idroom): self
    {
        $this->idroom = $idroom;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }


}
