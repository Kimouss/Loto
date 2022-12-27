<?php

namespace App\Twig\Components;

use App\Repository\DrawRepository;
use App\Service\PackageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('search_numbers')]
class SearchNumbersComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?string $query = null;

    public function __construct(
        private readonly DrawRepository     $drawRepository,
        private readonly PaginatorInterface $paginator,
        private readonly RequestStack $requestStack,
    )
    {
    }

    public function getPagination()
    {
        $query = $this->drawRepository->getAllQuery();

        return $this->paginator->paginate(
            $query,
            $this->requestStack->getCurrentRequest()->query->getInt('page', 2),
            10
        );
    }
}
