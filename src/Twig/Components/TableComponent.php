<?php

namespace App\Twig\Components;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('table')]
class TableComponent
{
    use DefaultActionTrait;

    public array $header;

    public array $rows;

    public function getHeader(): array
    {
        return $this->header;
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
