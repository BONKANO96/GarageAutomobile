<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Le prix est obligatoire.')]
    private ?string $price = null;

    #[ORM\Column(type: 'string', length: 4)]
    #[Assert\NotBlank(message: 'L\'année de mise en circulation est obligatoire.')]
    #[Assert\Regex(
        pattern: '/^\d{4}$/',
        message: 'L\'année doit être un nombre à 4 chiffres.'
    )]
    private ?string $year = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Le kilométrage est obligatoire.')]
    #[Assert\GreaterThan(value: 0, message: 'Le kilométrage doit être un nombre positif.')]
    private ?int $mileage = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $mainImageFilename = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private array $gallery = [];

    #[ORM\Column(type: 'json', nullable: true)]
    private array $features = [];

    #[ORM\Column(type: 'json', nullable: true)]
    private array $options = [];

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;
        return $this;
    }

    public function getMainImageFilename(): ?string
    {
        return $this->mainImageFilename;
    }

    public function setMainImageFilename(?string $mainImageFilename): self
    {
        $this->mainImageFilename = $mainImageFilename;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getGallery(): array
    {
        return $this->gallery;
    }

    public function setGallery(array $gallery): self
    {
        $this->gallery = $gallery;
        return $this;
    }

    public function getFeatures(): array
    {
        return $this->features;
    }

    public function setFeatures(array $features): self
    {
        $this->features = $features;
        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }
}
