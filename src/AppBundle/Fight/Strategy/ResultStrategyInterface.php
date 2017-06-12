<?php

namespace AppBundle\Fight\Strategy;

use AppBundle\Character\CharacterInterface;

/**
 * Interface ResultStrategyInterface
 * @package AppBundle\Fight\Strategy
 */
interface ResultStrategyInterface
{
    /**
     * @param CharacterInterface $attacker
     * @param CharacterInterface $defender
     * @return bool
     */
    public function getResult(CharacterInterface $attacker, CharacterInterface $defender) : bool;
}
