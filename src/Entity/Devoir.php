<?php

namespace App\Entity;

use App\Repository\DevoirRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DevoirRepository::class)]
class Devoir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $iddevoir = null;


    #[Assert\NotBlank(message:"donne pas vide!!")]
    #[Assert\Length(min: 2,minMessage: 'name plus que 2 character')]
    #[ORM\Column(length: 150)]
    private ?string $namedevoir = null;


    #[Assert\NotBlank(message:"donne pas vide!!")]
    #[ORM\Column(length: 150)]
    private ?string $dureedevoir = null;


    #[Assert\NotBlank(message:"donne pas vide!!")]
    #[ORM\Column(length: 150)]
    private ?string $datecreation = null;


    #[Assert\NotBlank(message:"donne pas vide!!")]
    #[ORM\Column(length: 150)]
    private ?string $contenu = null;

    #[ORM\Column(length: 150)]
    private ?string $category = null;

    #[ORM\OneToMany(mappedBy:'iddevoir',targetEntity: Question::class)]
    private Collection $questions;
    public function getIddevoir(): ?int
    {
        return $this->iddevoir;
    }

    public function getNamedevoir(): ?string
    {
        return $this->namedevoir;
    }

    public function setNamedevoir(?string $namedevoir): self
    {
        $this->namedevoir = $namedevoir;

        return $this;
    }

    public function getDureedevoir(): ?string
    {
        return $this->dureedevoir;
    }

    public function setDureedevoir(?string $dureedevoir): self
    {
        $this->dureedevoir = $dureedevoir;

        return $this;
    }

    public function getDatecreation(): ?string
    {
        return $this->datecreation;
    }

    public function setDatecreation(?string $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

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


}
