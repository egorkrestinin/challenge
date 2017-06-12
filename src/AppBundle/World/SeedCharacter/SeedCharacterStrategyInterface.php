<?php

namespace AppBundle\World\SeedCharacter;

use AppBundle\Character\CharacterInterface;
use AppBundle\World\WorldInterface;

/**
 * Interface SeedCharacterStrategyInterface
 * @package AppBundle\World\SeedCharacter
 */
interface SeedCharacterStrategyInterface
{
    public function seed(WorldInterface $world, CharacterInterface $character);
}
