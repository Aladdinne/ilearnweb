<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idquestion = null;

    #[ORM\Column]
    private ?int $numquestion = null;

    #[ORM\Column(length: 150)]
    private ?string $contenu = null;

    #[ORM\Column(length: 150)]
    private ?string $reponse;

    #[ORM\Column]
    private ?float $point = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?Devoir $iddevoir = null;

    public function getIdquestion(): ?int
    {
        return $this->idquestion;
    }

    public function getNumquestion(): ?int
    {
        return $this->numquestion;
    }

    public function setNumquestion(int $numquestion): self
    {
        $this->numquestion = $numquestion;

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

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getPoint(): ?float
    {
        return $this->point;
    }

    public function setPoint(?float $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getIddevoir(): ?Devoir
    {
        return $this->iddevoir;
    }

    public function setIddevoir(?Devoir $iddevoir): self
    {
        $this->iddevoir = $iddevoir;

        return $this;
    }


}
