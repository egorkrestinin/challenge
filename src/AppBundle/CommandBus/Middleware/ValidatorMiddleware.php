<?php

namespace AppBundle\CommandBus\Middleware;

use League\Tactician\Middleware;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorMiddleware implements Middleware
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var string
     */
    protected $group;

    /**
     * ValidatorMiddleware constructor.
     * @param ValidatorInterface|null $validator
     * @param string|null $group
     */
    public function __construct(ValidatorInterface $validator = null, string $group = null)
    {
        $this->validator = $validator;
        $this->group = $group;
    }

    /**
     * @param object $command
     * @param callable $next
     * @return mixed
     * @throws InvalidCommandException
     * @throws \Exception
     */
    public function execute($command, callable $next)
    {
        if ($this->validator === null) {
            throw new \Exception(
                "The Validator Middleware requires the Validator service (@validator) to be present and configured." .
                "Please configure it."
            );
        }

        $constraintViolations = $this->validator->validate($command, null, $this->group);

        if (count($constraintViolations) > 0) {
            throw InvalidCommandException::onCommand($command, $constraintViolations);
        }

        return $next($command);
    }
}

