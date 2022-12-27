<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class strPadExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('str_pad', [$this, 'strpad'])
        ];
    }

    public function strpad(string $number, string $padLength, string $padString): string
    {
        return str_pad($number, $padLength, $padString, STR_PAD_LEFT);
    }
}
