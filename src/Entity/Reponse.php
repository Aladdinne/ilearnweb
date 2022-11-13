<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReponseRepository;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idreponse = null;

    #[ORM\Column(length: 150)]
    private ?string $contenu = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column]
    private ?bool $etat = null;

    
    #[ORM\ManyToOne(inversedBy: 'reponse')]
    private ?Question $idquestion = null;

    
    #[ORM\ManyToOne(inversedBy: 'reponses')]
    private ?User $idetudiant = null;

    public function getIdreponse(): ?int
    {
        return $this->idreponse;
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

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdquestion(): ?Question
    {
        return $this->idquestion;
    }

    public function setIdquestion(?Question $idquestion): self
    {
        $this->idquestion = $idquestion;

        return $this;
    }

    public function getIdetudiant(): ?User
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(?User $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }


}
