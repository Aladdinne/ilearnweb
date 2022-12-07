<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idrdv = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $daterdv = null;

    #[ORM\Column(length: 150)]
    private ?string $dureerdv = null;

    #[ORM\Column]
    private ?int $tel = null;

    #[ORM\Column(length: 150)]
    private ? string $motif = null;

    #[ORM\Column(length: 150)]
    private ?string $etatrdv = null;

    
    #[ORM\Column]
    private ?int $idformateur = null;

    #[ORM\Column]
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
