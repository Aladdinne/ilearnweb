<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcommentaire = null;

    #[ORM\Column]
    private ?int $parentId = null;

    #[ORM\Column(length: 150)]
    private ?string $contentcommentaire = null;

    #[ORM\Column(length: 150)]
    private ?string $emailcommentaire = null;

    #[ORM\Column]
    private ?int $nickname = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?bool $rgpd = null;

    public function getIdcommentaire(): ?int
    {
        return $this->idcommentaire;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function getContentcommentaire(): ?string
    {
        return $this->contentcommentaire;
    }

    public function setContentcommentaire(?string $contentcommentaire): self
    {
        $this->contentcommentaire = $contentcommentaire;

        return $this;
    }

    public function getEmailcommentaire(): ?string
    {
        return $this->emailcommentaire;
    }

    public function setEmailcommentaire(string $emailcommentaire): self
    {
        $this->emailcommentaire = $emailcommentaire;

        return $this;
    }

    public function getNickname(): ?int
    {
        return $this->nickname;
    }

    public function setNickname(int $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isRgpd(): ?bool
    {
        return $this->rgpd;
    }

    public function setRgpd(bool $rgpd): self
    {
        $this->rgpd = $rgpd;

        return $this;
    }


}
