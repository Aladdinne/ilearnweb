<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idarticle = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message:"Doit saisir un Titre") ]
    #[Assert\Length(
        min: 5,
        max: 15,
        minMessage:'le title doit contenir au min 5 caractère',
        maxMessage:'e title doit contenir au min 15 caractère',)]
    private ?string $nomarticle = null;

    #[ORM\Column]
    private ?int $idcreateur;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $datecreation = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message:"Doit saisir un contenu") ]
    #[Assert\Length(
        min: 100,
        minMessage:'l article doit contenir plus',)]
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
    public function __construct()
    {
        $datetime=new \DateTime('now');
        $this->date =date_format($datetime, 'Y-m-d');
        // $this->date =  new \DateTime('now');
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
