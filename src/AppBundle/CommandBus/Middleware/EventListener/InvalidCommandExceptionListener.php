<?php

namespace AppBundle\CommandBus\Middleware\EventListener;

use AppBundle\CommandBus\Middleware\InvalidCommandException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class InvalidCommandExceptionListener
 * @package AppBundle\CommandBus\Middleware\EventListener
 */
class InvalidCommandExceptionListener
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * InvalidCommandExceptionListener constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        do {
            if ($exception instanceof InvalidCommandException) {
                return $this->handleException($event, $exception);
            }
        } while (null !== $exception = $exception->getPrevious());
    }

    /**
     * @param GetResponseForExceptionEvent $event
     * @param InvalidCommandException $exception
     */
    protected function handleException(GetResponseForExceptionEvent $event, InvalidCommandException $exception)
    {
        $code = $exception->getCode();

        $message = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'violations' => json_decode($this->serializer->serialize($exception->getViolations(), 'json'))
        ];

        $response = JsonResponse::create($message, $code, [
            'Cache-Control' => 'no-store',
            'Pragma' => 'no-cache',
        ]);

        $event->setResponse($response);
    }
}

