<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigTimeAgoExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('ago', [$this, 'timeAgo'], ['is_safe' => ['html']]),
        ];
    }

    public function timeAgo(\DateTimeInterface $date, string $prefix = ''): string
    {
        $prefixAttribute = !empty($prefix) ? "prefix=\"{$prefix}\"" : '';

        return "<time-ago time=\"{$date->getTimestamp()}\" $prefixAttribute ></time-ago>";
    }
}