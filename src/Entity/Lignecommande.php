<?php

namespace App\Entity;

use App\Repository\LignecommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LignecommandeRepository::class)]
class Lignecommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idlignecommand = null;

    #[ORM\Column]
    private ?float $prix = null;

    
    #[ORM\Column]
    private ?int $idcommand =  null;

   
    #[ORM\Column]
    private ?int $idformation = null;

    public function getIdlignecommand(): ?int
    {
        return $this->idlignecommand;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdcommand(): ?int
    {
        return $this->idcommand;
    }

    public function setIdcommand(?int $idcommand): self
    {
        $this->idcommand = $idcommand;

        return $this;
    }

    public function getIdformation(): ?int
    {
        return $this->idformation;
    }

    public function setIdformation(?int $idformation): self
    {
        $this->idformation = $idformation;

        return $this;
    }


}
