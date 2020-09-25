<?php

namespace App\Twig;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Système d'assets servant de remplacement à SymfonyEncore basé sur Vite.
 */
class TwigHideUsernameExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [ 
            new TwigFilter('hide_name', [$this, 'hideName']),
        ];    
    }

    public function hideName ($name)
    {
        if(strlen($name) <= 4)
        {
            return substr($name, 0, 1).str_repeat('*', strlen($name) - 2 ).substr($name, strlen($name) - 1);
        }
        return substr($name, 0, 2).str_repeat('*', strlen($name) - 4 ).substr($name, strlen($name) - 2);
    }
}