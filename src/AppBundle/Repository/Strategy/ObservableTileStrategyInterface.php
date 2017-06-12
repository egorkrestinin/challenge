<?php

namespace AppBundle\Repository\Strategy;

use AppBundle\Character\CharacterInterface;

/**
 * Interface ObservableTileStrategyInterface
 * @package AppBundle\Repository\Strategy
 */
interface ObservableTileStrategyInterface
{
    /**
     * @param CharacterInterface $character
     * @return mixed
     */
    public function getObservableTiles(CharacterInterface $character);
}
