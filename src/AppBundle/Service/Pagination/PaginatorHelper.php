<?php

namespace AppBundle\Service\Pagination;

use Symfony\Component\HttpFoundation\Request;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Knp\Component\Pager\Pagination\PaginationInterface;

class PaginatorHelper
{
    public function getPaginator(PaginationInterface $pagination, Request $request, string $pageParameter)
    {
        return new PaginatedRepresentation(
            new CollectionRepresentation($pagination->getItems()),
            $request->attributes->get('_route'),
            $request->attributes->get('_route_params'),
            $pagination->getCurrentPageNumber(),
            $pagination->getItemNumberPerPage(),
            ceil($pagination->getTotalItemCount() / $pagination->getItemNumberPerPage()) ?: 1,
            $pageParameter,
            null,
            false,
            $pagination->getTotalItemCount()
        );
    }
}
