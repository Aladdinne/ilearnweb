<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Entity(repositoryClass: CommandRepository::class)]
class Command
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcommand = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $datecommand = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Ecrire total')]
    #[Assert\Length(min: 2, minMessage: 'Contenue est vide')]
    private ?int $total = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'post.blank_content')]
    private ?string $etat = "encour";

    
    #[ORM\Column]
   /* #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'iduser')]
    #[ORM\JoinTable(
        name: 'iduser',
        joinColumns: [
            new ORM\JoinColumn(name: 'command', referencedColumnName: 'iduser'),
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'user', referencedColumnName: 'iduser'),
        ],
    )]*/
    private int $iduser;

    public function getIdcommand(): ?int
    {
        return $this->idcommand;
    }

    public function getDatecommand(): ?\DateTimeInterface
    {
        return $this->datecommand;
    }

    public function setDatecommand(?\DateTimeInterface $datecommand): self
    {
        $this->datecommand = $datecommand;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
