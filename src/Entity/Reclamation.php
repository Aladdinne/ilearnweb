<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
//use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idreclamation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTime $datereclamation = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "ecrire le contenue")]
    #[Assert\Length(min:8,max:150,maxMessage:'le contenue est trop long',minMessage:'Le contenue est tres court')]
    private ?string $contenu = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Modifier l'etat")]
    private ?string $etatreclamation = 'non-traite';

    #[ORM\Column]
     private ?string $captcha=null;
    #[ORM\Column]
    #[Assert\NotBlank(message: "ecrire votre Id")]
    private ?int  $iduser = null;

    #[ORM\Column]
   // #[Assert\NotBlank(message: "entre un id valide")]
    private ?int $idcategory = null;

    public function getIdreclamation(): ?int
    {
        return $this->idreclamation;
    }
    public function __construct()
{
    $datetime=new \DateTime('now');
    $this->date =date_format($datetime, 'Y-m-d');
 
}

    public function getDatereclamation(): ?\DateTimeInterface
    {
        return $this->datereclamation;
    }

    public function setDatereclamation(?\DateTimeInterface $datereclamation): self
    {
        $this->datereclamation =$datereclamation;

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

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

   public function getIdcategory(): ?int
    {
        return $this->idcategory;
    }

    public function setIdcategory(int $idcategory): self
    {
        $this->idcategory = $idcategory;

        return $this;
    }
     /**
      * Get the value of captcha
      */ 
     public function getCaptcha()
     {
          return $this->captcha;
     }

     /**
      * Set the value of captcha
      *
      * //return  self
      */ 
     public function setCaptcha($captcha)
     {
          $this->captcha = $captcha;

          return $this;
     }
}
