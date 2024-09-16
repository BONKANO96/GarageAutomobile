<?php

namespace App\Twig;

use App\Repository\OpeningHoursRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GlobalVariables extends AbstractExtension
{
    private $openingHoursRepository;

    public function __construct(OpeningHoursRepository $openingHoursRepository)
    {
        $this->openingHoursRepository = $openingHoursRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_opening_hours', [$this, 'getOpeningHours']),
        ];
    }

    public function getOpeningHours()
    {
        return $this->openingHoursRepository->findAll();
    }
}
