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

    
    #[ORM\ManyToOne(inversedBy: 'lignecom')]
    private ?Command $idcommand =  null;

   
    #[ORM\ManyToOne(inversedBy: 'lignecomman')]
    private ?Formation $idformation = null;

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

    public function getIdcommand(): ?Command
    {
        return $this->idcommand;
    }

    public function setIdcommand(?Command $idcommand): self
    {
        $this->idcommand = $idcommand;

        return $this;
    }

    public function getIdformation(): ?Formation
    {
        return $this->idformation;
    }

    public function setIdformation(?Formation $idformation): self
    {
        $this->idformation = $idformation;

        return $this;
    }


}
