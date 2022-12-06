<?php

namespace App\Entity;

use App\Repository\CategoryrecRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryrecRepository::class)]
class Categoryrec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcategory = null;

    #[ORM\Column(length: 150)]
    private ?string $category = null;

    public function getIdcategory(): ?int
    {
        return $this->idcategory;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }


}
