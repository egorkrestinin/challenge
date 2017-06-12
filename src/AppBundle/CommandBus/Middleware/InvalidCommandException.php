<?php

namespace AppBundle\CommandBus\Middleware;

use League\Tactician\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class InvalidCommandException
 * @package AppBundle\CommandBus\Middleware
 */
class InvalidCommandException extends \Exception implements Exception, HttpExceptionInterface
{
    /**
     * @var object
     */
    protected $command;

    /**
     * @var ConstraintViolationListInterface
     */
    protected $violations;

    /**
     * @var array
     */
    public $errors;

    /**
     * @param object $command
     * @param ConstraintViolationListInterface $violations
     * @return static
     */
    public static function onCommand($command, ConstraintViolationListInterface $violations)
    {
        $exception = new static(
            sprintf('Validation failed with %d violations', $violations->count())
        );

        $exception->command    = $command;
        $exception->violations = $violations;
        $exception->code = Response::HTTP_BAD_REQUEST;
        $exception->errors = ['errors'];

        return $exception;
    }

    /**
     * @return object
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return Response::HTTP_BAD_REQUEST;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [];
    }
}
