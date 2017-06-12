<?php

namespace AppBundle\Controller;

use AppBundle\Turn\Command\CreateTurnCommand;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TurnController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Configuration\ParamConverter("command", converter="fos_rest.request_body")
     *
     * @ApiDoc(
     *     section = "Turns",
     *     description="Create a new turn for the character",
     *     resource=false,
     *     input={
     *         "class"="AppBundle\Turn\Command\CreateTurnCommand"
     *     },
     *     statusCodes = {
     *         Response::HTTP_CREATED = "Returned when turn is created"
     *     },
     *     requirements={
     *      {
     *          "name"="characterId",
     *          "dataType"="uuid",
     *          "description"="Character identifier"
     *      }
     *    }
     * )
     *
     * @FOSRest\View
     * @FOSRest\Post("/characters/{characterId}/turns")
     *
     * @param string $characterId
     * @param CreateTurnCommand $command
     * @return View
     */
    public function postAction(string $characterId, CreateTurnCommand $command)
    {
        $character = $this->get('app.repository.character')->findNonNPC($characterId);
        if (!$character) {
            throw new NotFoundHttpException("Character not found");
        }

        $command->setCharacter($character);
        $this->get('tactician.commandbus')->handle($command);

        return View::create(null, Response::HTTP_CREATED);
    }
}
