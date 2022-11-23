<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[UniqueEntity('nomformation',message: "Cette formation existe déja")]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idformation = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veillez remplir ce champ ")]
    #[Assert\Length(min: 6,minMessage: "veillez avoir au moins 6 charactère")]
    private ?string $nomformation = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veillez remplir ce champ")]
    #[Assert\Length(min: 8,minMessage: "veillez avoir au moins 8 charactère")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThanOrEqual('today',message: "veillez ")]

    private ?DateTimeInterface $datecreation = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veillez remplir ce champ")]
    #[Assert\Time(message: "vérifiez le format de la durée")]
    private ?string $duree = null;

    #[ORM\Column(length: 150)]

    private ?string $category = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "veillez remplir un prix")]
    #[Assert\Positive(message: "veillez remplir un prix valide")]

    private ?float $prix = null;

    public function getIdformation(): ?int
    {
        return $this->idformation;
    }

    public function getNomformation(): ?string
    {
        return $this->nomformation;
    }

    public function setNomformation(?string $nomformation): self
    {
        $this->nomformation = $nomformation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
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


}
