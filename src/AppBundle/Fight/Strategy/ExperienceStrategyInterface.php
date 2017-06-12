<?php

namespace AppBundle\Fight\Strategy;

use AppBundle\Character\CharacterInterface;

/**
 * Interface ExperienceStrategyInterface
 * @package AppBundle\Fight\Strategy
 */
interface ExperienceStrategyInterface
{
    /**
     * @param CharacterInterface $attacker Attacker
     * @param CharacterInterface $defender Deffender
     * @return int Received experience
     */
    public function calculateReceivedExperience(CharacterInterface $attacker, CharacterInterface $defender) : int;
}
