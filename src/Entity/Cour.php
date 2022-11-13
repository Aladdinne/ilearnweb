<?php

namespace App\Entity;

use App\Repository\CourRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourRepository::class)]
class Cour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcour = null;

    #[ORM\Column(length: 150)]
    private ?string $nomcour = null;

    #[ORM\Column(length: 150)]
    private ?string $nomformateur = null;

    #[ORM\Column(length: 150)]
    private ?string $pdf = null;

    #[ORM\Column(length: 150)]
    private ?string $video = null;

    
    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Formation $idformation = null;

    public function getIdcour(): ?int
    {
        return $this->idcour;
    }

    public function getNomcour(): ?string
    {
        return $this->nomcour;
    }

    public function setNomcour(string $nomcour): self
    {
        $this->nomcour = $nomcour;

        return $this;
    }

    public function getNomformateur(): ?string
    {
        return $this->nomformateur;
    }

    public function setNomformateur(string $nomformateur): self
    {
        $this->nomformateur = $nomformateur;

        return $this;
    }

    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    public function setPdf(string $pdf): self
    {
        $this->pdf = $pdf;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

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
