<?php

namespace AppBundle\Controller;

use AppBundle\Character\Command\CreateCharacterCommand;
use AppBundle\World\TileInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Hateoas\Representation\PaginatedRepresentation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CharacterController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Configuration\ParamConverter("command", converter="fos_rest.request_body")
     *
     * @ApiDoc(
     *     section = "Characters",
     *     description="Create a new character",
     *     resource=false,
     *     input={
     *         "class"="AppBundle\Character\Command\CreateCharacterCommand"
     *     },
     *     statusCodes = {
     *         Response::HTTP_CREATED = "Returned when character is created"
     *     }
     * )
     *
     * @FOSRest\View
     * @FOSRest\Post("/characters")
     *
     * @param CreateCharacterCommand $command
     * @return View
     */
    public function postAction(CreateCharacterCommand $command)
    {
        $this->get('tactician.commandbus')->handle($command);
        return View::create(null, Response::HTTP_CREATED);
    }

    /**
     * @ApiDoc(
     *     section = "Characters",
     *     description="Get the characters collection",
     *     resource=true,
     *     parameters={
     *          {"name"="page", "dataType"="integer", "required"=false, "description"="Page number"}
     *     }
     * )
     *
     * @FOSRest\Get("/characters")
     * @param Request $request
     *
     * @return PaginatedRepresentation
     */
    public function getCharactersAction(Request $request)
    {
        $pagination = $this->get('knp_paginator')->paginate(
            $this->get('app.repository.character')->getFindAllNonNPCQuery(),
            $request->get('page', 1),
            $this->getParameter('app.defaults.collection_page_size')
        );

        return $this->get('app.helper.paginator')->getPaginator($pagination, $request, 'page');
    }
}
