<?php

namespace AppBundle\Fight\EventListener;

use AppBundle\Fight\Event\FightResultEvent;
use AppBundle\Fight\Strategy\ResultStrategyInterface;
use AppBundle\Repository\CharacterRepository;
use AppBundle\Turn\Event\TurnEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FightEventListener
{
    /**
     * @var CharacterRepository
     */
    protected $characterRepository;

    /**
     * @var ResultStrategyInterface
     */
    protected $resultStrategy;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * FightEventListener constructor.
     * @param CharacterRepository $characterRepository
     * @param ResultStrategyInterface $resultStrategy
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        CharacterRepository $characterRepository,
        ResultStrategyInterface $resultStrategy,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->characterRepository = $characterRepository;
        $this->resultStrategy = $resultStrategy;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param TurnEvent $turnEvent
     */
    public function onTurnCreated(TurnEvent $turnEvent)
    {
        $character =  $turnEvent->getTurn()->getCharacter();
        $enemies = $this->characterRepository->getAllEnemiesOnCharacterTile($character);

        foreach ($enemies as $enemy) {
            if ($this->resultStrategy->getResult($character, $enemy)) {
                $this->eventDispatcher->dispatch(
                    FightResultEvent::ON_FIGHT,
                    new FightResultEvent($character, $enemy)
                );
            } else {
                $this->eventDispatcher->dispatch(
                    FightResultEvent::ON_FIGHT,
                    new FightResultEvent($enemy, $character)
                );
            }
        }
    }
}
