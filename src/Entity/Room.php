<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idroom = null; 

    #[ORM\Column(length: 150)]
    private ?string $nomroom = null;

    #[ORM\Column(length: 150)]
    private ?string $nomcreator = null;

    #[ORM\Column(length: 150)]
    private ?string $nomrecepteur = null;

    public function getIdroom(): ?int
    {
        return $this->idroom;
    }

    public function getNomroom(): ?string
    {
        return $this->nomroom;
    }

    public function setNomroom(?string $nomroom): self
    {
        $this->nomroom = $nomroom;

        return $this;
    }

    public function getNomcreator(): ?string
    {
        return $this->nomcreator;
    }

    public function setNomcreator(?string $nomcreator): self
    {
        $this->nomcreator = $nomcreator;

        return $this;
    }

    public function getNomrecepteur(): ?string
    {
        return $this->nomrecepteur;
    }

    public function setNomrecepteur(?string $nomrecepteur): self
    {
        $this->nomrecepteur = $nomrecepteur;

        return $this;
    }


}
