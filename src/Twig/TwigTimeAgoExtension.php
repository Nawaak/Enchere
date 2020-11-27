<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigTimeAgoExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [
            new TwigFilter('ago', [$this, 'timeAgo'], ['is_safe' => ['html']]),
        ];
    }

    public function timeAgo(\DateTimeInterface $date, $prefix = '')
    {
        $prefixAttribute = !empty($prefix) ? "prefix=\"{$prefix}\"" : '';

        return "<time-ago time=\"{$date->getTimestamp()}\" $prefixAttribute ></time-ago>";
    }
}