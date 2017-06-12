<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Hateoas\Representation\PaginatedRepresentation;

/**
 * Class WorldController
 * @package AppBundle\Controller
 */
class WorldController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *  section="Worlds",
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when the character isn't found"
     *  },
     *  description="Returns the observable world's tiles for the character",
     *  requirements={
     *      {
     *          "name"="characterId",
     *          "dataType"="uuid",
     *          "description"="Character identifier"
     *      }
     *  }
     * )
     *
     * @FOSRest\Get("/characters/{characterId}/tiles")
     *
     * @param string $characterId
     * @param Request $request
     * @return PaginatedRepresentation
     */
    public function getCharacterTilesAction(string $characterId, Request $request)
    {
        $character = $this->get('app.repository.character')->findNonNPC($characterId);
        if (!$character) {
            throw new NotFoundHttpException("Character not found");
        }

        $pagination = $this->get('knp_paginator')->paginate(
            $this->get('app.service.character.observable_tiles_strategy')->getObservableTiles($character),
            $request->get('page', 1),
            PHP_INT_MAX
        );

        return $this->get('app.helper.paginator')->getPaginator($pagination, $request, 'page');
    }
}
