<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idrdv = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: 'post.blank_content')]
    private ?\DateTimeInterface $daterdv = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'post.blank_content')]
    private ?string $dureerdv = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'post.blank_content')]
    #[Assert\Length(min: 8,max: 8 ,maxMessage : 'post.too_long_content',minMessage: 'post.too_short_content')]
    private ?int $tel = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'post.blank_content')]
    #[Assert\Length(min: 10, minMessage: 'post.too_short_content')]
    private ? string $motif = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'post.blank_content')]
    #[Assert\Length(min: 5, minMessage: 'post.too_short_content')]
    private ?string $etatrdv = "en attendant";

    
    #[ORM\Column]
    private ?int $idformateur = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'post.blank_content')]
    private ?int $idclient = null;

    public function getIdrdv(): ?int
    {
        return $this->idrdv;
    }

    public function getDaterdv(): ?\DateTimeInterface
    {
        return $this->daterdv;
    }

    public function setDaterdv(?\DateTimeInterface $daterdv): self
    {
        $this->daterdv = $daterdv;

        return $this;
    }

    public function getDureerdv(): ?string
    {
        return $this->dureerdv;
    }

    public function setDureerdv(?string $dureerdv): self
    {
        $this->dureerdv = $dureerdv;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getEtatrdv(): ?string
    {
        return $this->etatrdv;
    }

    public function setEtatrdv(string $etatrdv): self
    {
        $this->etatrdv = $etatrdv;

        return $this;
    }

    public function getIdformateur(): ?int
    {
        return $this->idformateur;
    }

    public function setIdformateur(?int $idformateur): self
    {
        $this->idformateur = $idformateur;

        return $this;
    }

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function setIdclient(?int $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }


}
