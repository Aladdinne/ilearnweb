<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $idreclamation;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $datereclamation = null;

    #[ORM\Column(length: 150)]
    private ?string $contenu = null;

    #[ORM\Column(length: 150)]
    private ?string $etatreclamation = 'non-traite';

<<<<<<< HEAD
 
    #[ORM\Column]
    //#[Assert\NotBlank(message: "ecrire votre Id")]
    private ?int  $iduser = null;
=======
    
    #[ORM\OneToOne(inversedBy: 'rec')]
    private ?User $iduser = null;
>>>>>>> refs/remotes/origin/main

    
    #[ORM\ManyToOne(inversedBy: 'categoryrec')]
    private ?Categoryrec $idcategory = null;

    public function getIdreclamation(): ?int
    {
        return $this->idreclamation;
    }
<<<<<<< HEAD
    public function __construct()
{
    $datetime=new \DateTime('now');
    $this->date =date_format($datetime, 'Y-m-d');
}
=======
>>>>>>> refs/remotes/origin/main

    public function getDatereclamation(): ?\DateTimeInterface
    {
        return $this->datereclamation;
    }

    public function setDatereclamation(?\DateTimeInterface $datereclamation): self
    {
        $this->datereclamation = $datereclamation;

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

    public function getEtatreclamation(): ?string
    {
        return $this->etatreclamation;
    }

    public function setEtatreclamation(string $etatreclamation): self
    {
        $this->etatreclamation = $etatreclamation;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdcategory(): ?Categoryrec
    {
        return $this->idcategory;
    }

    public function setIdcategory(?Categoryrec $idcategory): self
    {
        $this->idcategory = $idcategory;

        return $this;
    }
<<<<<<< HEAD
      

     
=======


>>>>>>> refs/remotes/origin/main
}
