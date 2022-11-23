<?php

namespace App\Entity;

use App\Repository\CourRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CourRepository::class)]
#[UniqueEntity('nomcour',message: "Ce cour existe déja")]
class Cour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcour = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veillez remplir ce champ ")]
    #[Assert\Length(min: 6,minMessage: "veillez avoir au moins 6 charactère")]
    private ?string $nomcour = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veillez remplir ce champ ")]
    #[Assert\Length(min: 6,minMessage: "veillez avoir au moins 6 charactère")]
    private ?string $nomformateur = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veillez remplir ce champ ")]
    private ?string $pdf = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "veillez remplir ce champ ")]
    private ?string $video = null;


    #[ORM\Column(length: 150)]
    private ?int $idformation = null;

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
