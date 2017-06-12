<?php

namespace AppBundle\World\EventListener;

use AppBundle\Character\CharacterInterface;
use AppBundle\Character\Event\CharacterEvent;
use AppBundle\Repository\WorldRepository;
use AppBundle\World\Event\WorldEvent;
use AppBundle\World\Factory\WorldFactory;
use AppBundle\World\SeedCharacter\SeedCharacterStrategyInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class CreateWorldForCharacterListener
 * @package AppBundle\World\EventListener
 */
class CreateWorldForCharacterListener
{
    /**
     * @var WorldFactory
     */
    protected $worldFactory;

    /**
     * @var SeedCharacterStrategyInterface
     */
    protected $seedCharacterStrategy;

    /**
     * @var WorldRepository
     */
    protected $worldRepository;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * CreateWorldForCharacterListener constructor.
     * @param WorldFactory $worldFactory
     * @param WorldRepository $worldRepository
     * @param SeedCharacterStrategyInterface $seedCharacterStrategy
     */
    public function __construct(
        WorldFactory $worldFactory,
        WorldRepository $worldRepository,
        SeedCharacterStrategyInterface $seedCharacterStrategy,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->worldFactory = $worldFactory;
        $this->worldRepository = $worldRepository;
        $this->seedCharacterStrategy = $seedCharacterStrategy;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param CharacterEvent $characterEvent
     */
    public function onCreated(CharacterEvent $characterEvent)
    {
        $character = $characterEvent->getCharacter();
        if (!$character->getType() === CharacterInterface::TYPE_PLAYER) {
            return;
        }

        $world = $this->worldFactory->createWorld(Uuid::uuid4());
        $this->worldRepository->save($world);

        $this->seedCharacterStrategy->seed($world, $character);
        $this->worldRepository->save($world);
        $this->eventDispatcher->dispatch(WorldEvent::ON_CREATED, new WorldEvent($world));
    }
}
