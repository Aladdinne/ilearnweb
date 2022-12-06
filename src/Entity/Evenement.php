<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[UniqueEntity('sujetev')]

class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idevenement = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veuillez remplir ce champ !")]
    #[Assert\Length(min: 2, minMessage: 'veuillez avoir au moins 2 caractères !' , max:10,maxMessage:'veuillez avoir au maximum 10 caractères !')]
    private ?string $nomEvenement = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veuillez remplir ce champ !")]
    #[Assert\Length(min: 2, minMessage: 'veuillez avoir au moins 2 caractères !' , max:10,maxMessage:'veuillez avoir au maximum 10 caractères !')]
    private ?string $sujetev = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $dateev = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]

    private ?DateTimeInterface $heureev = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veuillez remplir ce champ !")]
    #[Assert\Length(min: 2, minMessage: 'veuillez avoir au moins 2 caractères !' , max:10,maxMessage:'veuillez avoir au maximum 10 caractères !')]
    private ?string $lieuev = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veuillez remplir ce champ !")]
    #[Assert\Length(min: 2, minMessage: 'veuillez avoir au moins 2 caractères !' , max:10,maxMessage:'veuillez avoir au maximum 10 caractères !')]
    private ?string $nomcreateurev = null;

    public function getIdevenement(): ?int
    {
        return $this->idevenement;
    }

    public function getNomEvenement(): ?string
    {
        return $this->nomEvenement;
    }

    public function setNomEvenement(string $nomEvenement): self
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    public function getSujetev(): ?string
    {
        return $this->sujetev;
    }

    public function setSujetev(string $sujetev): self
    {
        $this->sujetev = $sujetev;

        return $this;
    }

    public function getDateev(): ?\DateTimeInterface
    {
        return $this->dateev;
    }

    public function setDateev(\DateTimeInterface $dateev): self
    {
        $this->dateev = $dateev;

        return $this;
    }

    public function getHeureev(): ?\DateTimeInterface
    {
        return $this->heureev;
    }

    public function setHeureev(\DateTimeInterface $heureev): self
    {
        $this->heureev = $heureev;

        return $this;
    }

    public function getLieuev(): ?string
    {
        return $this->lieuev;
    }

    public function setLieuev(string $lieuev): self
    {
        $this->lieuev = $lieuev;

        return $this;
    }

    public function getNomcreateurev(): ?string
    {
        return $this->nomcreateurev;
    }

    public function setNomcreateurev(string $nomcreateurev): self
    {
        $this->nomcreateurev = $nomcreateurev;

        return $this;
    }


}
