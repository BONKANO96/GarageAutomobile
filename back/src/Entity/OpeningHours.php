<?php

namespace App\Entity;

use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OpeningHoursRepository::class)]
class OpeningHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\NotBlank(message: 'Le jour ne doit pas être vide.')]
    #[Assert\Choice(
        choices: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
        message: 'Veuillez choisir un jour valide.'
    )]
    private ?string $day = null;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    #[Assert\Regex(
        pattern: '/^(0[8-9]|1[0-9]|2[0-3]):([0-5][0-9])$/',
        message: 'Veuillez entrer une heure d\'ouverture valide au format HH:MM (de 08:00 à 23:59).'
    )]
    private ?string $openingTime = null;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    #[Assert\Regex(
        pattern: '/^(0[8-9]|1[0-9]|2[0-3]):([0-5][0-9])$/',
        message: 'Veuillez entrer une heure de fermeture valide au format HH:MM (de 08:00 à 23:59).'
    )]
    private ?string $closingTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningTime(): ?string
    {
        return $this->openingTime;
    }

    public function setOpeningTime(?string $openingTime): self
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?string
    {
        return $this->closingTime;
    }

    public function setClosingTime(?string $closingTime): self
    {
        $this->closingTime = $closingTime;

        return $this;
    }
}
