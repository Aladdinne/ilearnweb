<?php

namespace App\Entity;

use App\Repository\CourRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CourRepository::class)]
#[Vich\Uploadable]
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

    private ?string $pdf = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: "cour_pdf", fileNameProperty: "pdf")]
    private ?File $pdfFile = null;



    #[ORM\Column(length: 150)]
    private ?string $video = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: "cour_image", fileNameProperty: "video")]
    private ?File $imageFile = null;


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

    public function setPdf(?string $pdf): void
    {
        $this->pdf = $pdf;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): void
    {
        $this->video = $video;
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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $File
     */

    public function setPdfFile(?File $File = null): void
    {
        $this->pdfFile = $File;

    }

    public function getPdfFile(): ?File
    {
        return $this->pdfFile;
    }




}
