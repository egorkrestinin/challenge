<?php

namespace AppBundle\Fight\Strategy;

use AppBundle\Character\CharacterInterface;

/**
 * Class HealthBasedExperienceStrategy
 * @package AppBundle\Fight\Strategy
 */
class HealthBasedExperienceStrategy implements ExperienceStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function calculateReceivedExperience(CharacterInterface $winner, CharacterInterface $looser) : int
    {
        return $looser->getHealth();
    }
}
