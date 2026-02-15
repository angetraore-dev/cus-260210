<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
#[Vich\Uploadable]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'gallery_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $imageTitle = null;

    #[ORM\Column]
    private ?int $priority = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        // On initialise avec la date actuelle pour éviter le 0000-00-00
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageTitle(): ?string
    {
        return $this->imageTitle;
    }

    public function setImageTitle(string $imageTitle): static
    {
        $this->imageTitle = $imageTitle;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }
}
