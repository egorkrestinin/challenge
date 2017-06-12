<?php

namespace AppBundle\Turn\Command;

use AppBundle\Turn\Event\TurnEvent;
use AppBundle\Turn\Factory\TurnFactory;
use League\Tactician\CommandBus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CreateCharacterCommandHandler
 * @package AppBundle\Character\Command
 */
class CreateTurnCommandHandler
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var TurnFactory
     */
    protected $turnFactory;

    /**
     * CreateTurnCommandHandler constructor.
     * @param CommandBus $commandBus
     * @param TurnFactory $turnFactory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        CommandBus $commandBus,
        TurnFactory $turnFactory,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->commandBus = $commandBus;
        $this->turnFactory = $turnFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(CreateTurnCommand $command) : void
    {
        $turn = $this->turnFactory->createTurn(
            $command->getId(),
            $command->getCharacter(),
            $command->getTile()
        );

        $this->eventDispatcher->dispatch(TurnEvent::BEFORE_CREATED, new TurnEvent($turn));
        $this->commandBus->handle($turn);
        $this->eventDispatcher->dispatch(TurnEvent::AFTER_CREATED, new TurnEvent($turn));
    }
}
