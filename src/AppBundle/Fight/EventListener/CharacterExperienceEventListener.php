<?php

namespace AppBundle\Fight\EventListener;

use AppBundle\Fight\Event\FightResultEvent;
use AppBundle\Fight\Strategy\ExperienceStrategyInterface;
use AppBundle\Repository\CharacterRepository;

/**
 * Class CharacterExperienceEventListener
 * @package AppBundle\Fight\EventListener
 */
class CharacterExperienceEventListener
{
    /**
     * @var ExperienceStrategyInterface
     */
    protected $experienceStrategy;

    /**
     * @var CharacterRepository
     */
    protected $characterRepository;

    /**
     * CharacterExperienceEventListener constructor.
     * @param ExperienceStrategyInterface $experienceStrategy
     * @param CharacterRepository $characterRepository
     */
    public function __construct(
        ExperienceStrategyInterface $experienceStrategy,
        CharacterRepository $characterRepository
    ) {
        $this->experienceStrategy = $experienceStrategy;
        $this->characterRepository = $characterRepository;
    }

    /**
     * @param FightResultEvent $fightResultEvent
     */
    public function onFight(FightResultEvent $fightResultEvent)
    {
        $winner = $fightResultEvent->getWinner();
        $experience = $this->experienceStrategy->calculateReceivedExperience(
            $winner,
            $fightResultEvent->getLooser()
        );

        $winner->setExperience($winner->getExperience() + $experience);
        $this->characterRepository->save($winner);
    }
}
