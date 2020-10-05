<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Permet de masquer le pseudo de l'encherisseur (ex: Br***on => Brandon)
 */
class TwigHideUsernameExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [ 
            new TwigFilter('hide_name', [$this, 'hideName']),
        ];    
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function hideName (string $name): ?string
    {
        if(strlen($name) <= 5)
        {
            return mb_substr($name, 0, 1, 'UTF-8').str_repeat('*', strlen($name) - 2 ).mb_substr($name, mb_strlen($name) - 1, null, 'UTF-8');
        }
        return mb_substr($name, 0, 2, 'UTF-8').str_repeat('*', strlen($name) - 4 ).mb_substr($name, mb_strlen($name) - 2, null, 'UTF-8');
    }
}