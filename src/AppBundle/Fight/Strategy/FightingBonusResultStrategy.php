<?php

namespace AppBundle\Fight\Strategy;

use AppBundle\Character\CharacterInterface;
use AppBundle\Character\Ability\FightingBonusInterface;

/**
 * Class FightingBonusResultStrategy
 * @package AppBundle\Fight\Strategy
 */
class FightingBonusResultStrategy implements ResultStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getResult(CharacterInterface $attacker, CharacterInterface $defender) : bool
    {
        $damageCoefficient = $attacker->hasAbility(FightingBonusInterface::ABILITY)
            ? 1 + $attacker->getAbility(FightingBonusInterface::ABILITY) : 1;

        return $attacker->getStrength() * $damageCoefficient / $defender->getHealth()
        - $defender->getStrength() / $attacker->getHealth() > 0 ? true : false;
    }
}
