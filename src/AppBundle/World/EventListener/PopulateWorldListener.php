<?php

namespace AppBundle\World\EventListener;

use AppBundle\Character\CharacterInterface;
use AppBundle\Character\Event\CharacterEvent;
use AppBundle\Character\Factory\CharacterFactory;
use AppBundle\Character\Registry\CharacterRegistry;
use AppBundle\Repository\CharacterRepository;
use AppBundle\Repository\WorldRepository;
use AppBundle\World\Event\WorldEvent;
use AppBundle\World\Factory\WorldFactory;
use AppBundle\World\SeedCharacter\SeedCharacterStrategyInterface;
use AppBundle\World\WorldInterface;
use JMS\Serializer\EventDispatcher\EventDispatcherInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class PopulateWorldListener
 * @package AppBundle\World\EventListener
 */
class PopulateWorldListener
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
     * @var CharacterFactory
     */
    protected $characterFactory;

    /**
     * @var CharacterRegistry
     */
    protected $characterRegistry;

    /**
     * @var int
     */
    protected $enemyCount;

    /**
     * @var CharacterRepository
     */
    protected $characterRepository;
    /**
     * PopulateWorldListener constructor.
     * @param CharacterRegistry $characterRegistry
     * @param CharacterFactory $characterFactory
     * @param WorldRepository $worldRepository
     * @param CharacterRepository $characterRepository
     * @param SeedCharacterStrategyInterface $seedCharacterStrategy
     * @param int $enemyCount
     */
    public function __construct(
        CharacterRegistry $characterRegistry,
        CharacterFactory $characterFactory,
        WorldRepository $worldRepository,
        CharacterRepository $characterRepository,
        SeedCharacterStrategyInterface $seedCharacterStrategy,
        int $enemyCount
    ) {
        $this->characterFactory = $characterFactory;
        $this->characterRegistry = $characterRegistry;
        $this->worldRepository = $worldRepository;
        $this->characterRepository = $characterRepository;
        $this->seedCharacterStrategy = $seedCharacterStrategy;
        $this->enemyCount = $enemyCount;
    }

    /**
     * @param WorldEvent $worldEvent
     */
    public function onCreated(WorldEvent $worldEvent)
    {
        $world = $worldEvent->getWorld();

        foreach (range(1, $this->enemyCount) as $iterator) {
            $this->populateWorld($world);
        }
    }

    /**
     * @param WorldInterface $world
     */
    protected function populateWorld(WorldInterface $world)
    {
        $aliases = $this->characterRegistry->getAliases();
        $alias = $aliases[array_rand($aliases)];

        $character = $this->characterFactory->createCharacter(
            $alias,
            Uuid::uuid4(),
            CharacterInterface::TYPE_NPC
        );

        $this->seedCharacterStrategy->seed($world, $character);
        $this->characterRepository->save($character);
        $this->worldRepository->save($world);
    }
}
