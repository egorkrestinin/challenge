<?php

namespace AppBundle\Fight\EventListener;

use AppBundle\Fight\Event\FightResultEvent;
use AppBundle\Repository\CharacterRepository;

/**
 * Class CharacterHealthEventListener
 * @package AppBundle\Fight\EventListener
 */
class CharacterHealthEventListener
{
    /**
     * @var CharacterRepository
     */
    protected $characterRepository;

    /**
     * CharacterHealthEventListener constructor.
     * @param CharacterRepository $characterRepository
     */
    public function __construct(CharacterRepository $characterRepository)
    {
        $this->characterRepository = $characterRepository;
    }

    /**
     * @param FightResultEvent $fightResultEvent
     */
    public function onFight(FightResultEvent $fightResultEvent)
    {
        $fightResultEvent->getLooser()->setHealth(0);
        $this->characterRepository->save($fightResultEvent->getLooser());
    }
}
