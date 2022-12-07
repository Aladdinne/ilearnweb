<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
use Doctrine\Common\Collections\Collection;
=======
<<<<<<< HEAD
use Symfony\Component\Validator\Constraints\Length;
=======
>>>>>>> 8b4ef130ec757feb7d04e3bd39120ab95229a729
>>>>>>> main

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $iduser = null;

    #[ORM\Column(length: 150)]
    //#[Assert\NotBlank(message:"Doit saisir le nom") ]
    private ?string $nom = null;

    #[ORM\Column(length: 150)]
    //#[Assert\NotBlank(message:"Doit saisir un username") ]
    private ?string $username = null;

    #[ORM\Column(length: 150)]
<<<<<<< HEAD
=======
    /*#[Assert\NotBlank(message:"Doit saisir un password")]
    #[Assert\Length(min:5,
                    max:15,
                    minMessage:'le mot de passe doit contenir au min 5 caractère',
                    maxMessage:'le mot de passe doit contenir au max 15 caractère',) ]*/
>>>>>>> main
    private ?string $userpwd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface$daten;

    #[ORM\Column(length: 150)]
   // #[Assert\NotBlank(message:"Doit saisir un email") ]
   // #[Assert\Email(message:" is not a valid email")]
    private ?string $email = null;

    #[ORM\Column(length: 150)]
    private ?string $role = null;

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserpwd(): ?string
    {
        return $this->userpwd;
    }

    public function setUserpwd(?string $userpwd): self
    {
        $this->userpwd = $userpwd;

        return $this;
    }

    public function getDaten(): ?\DateTimeInterface
    {
        return $this->daten;
    }

    public function setDaten(?\DateTimeInterface $daten): self
    {
        $this->daten = $daten;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }


}
