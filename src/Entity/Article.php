<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idarticle = null;

    #[ORM\Column(length: 150)]
    private ?string $nomarticle = null;

    #[ORM\Column]
    private $idcreateur;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $datecreation = null;

    #[ORM\Column(length: 150)]
    private ?string $contenu = null;

    #[ORM\Column(length: 150)]
    private ?string $etatarticle = 'non_traité';

    public function getIdarticle(): ?int
    {
        return $this->idarticle;
    }

    public function getNomarticle(): ?string
    {
        return $this->nomarticle;
    }

    public function setNomarticle(?string $nomarticle): self
    {
        $this->nomarticle = $nomarticle;

        return $this;
    }

    public function getIdcreateur(): ?int
    {
        return $this->idcreateur;
    }

    public function setIdcreateur(?int $idcreateur): self
    {
        $this->idcreateur = $idcreateur;

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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getEtatarticle(): ?string
    {
        return $this->etatarticle;
    }

    public function setEtatarticle(string $etatarticle): self
    {
        $this->etatarticle = $etatarticle;

        return $this;
    }
    

}
