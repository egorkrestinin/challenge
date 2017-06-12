<?php

namespace AppBundle\Character\Command;

use AppBundle\Character\CharacterInterface;
use AppBundle\Character\Event\CharacterEvent;
use AppBundle\Character\Factory\CharacterFactory;
use League\Tactician\CommandBus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CreateCharacterCommandHandler
 * @package AppBundle\Character\Command
 */
class CreateCharacterCommandHandler
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @var CharacterFactory
     */
    protected $characterFactory;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * CreateCharacterCommandHandler constructor.
     * @param CommandBus $commandBus
     * @param CharacterFactory $characterFactory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        CommandBus $commandBus,
        CharacterFactory $characterFactory,

        EventDispatcherInterface $eventDispatcher
    ) {
        $this->commandBus = $commandBus;
        $this->characterFactory = $characterFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param CreateCharacterCommand $command
     */
    public function handle(CreateCharacterCommand $command) : void
    {
        $character = $this->characterFactory->createCharacter(
            $command->getPrototype(),
            $command->getId(),
            CharacterInterface::TYPE_PLAYER
        );
        $this->eventDispatcher->dispatch(CharacterEvent::ON_CREATED, new CharacterEvent($character));
        $this->commandBus->handle($character);
    }
}
