<?php

namespace AppBundle\Turn;

use AppBundle\Character\CharacterInterface;
use AppBundle\World\TileInterface;

/**
 * Interface TurnInterface
 * @package AppBundle\Turn
 */
interface TurnInterface
{
    /**
     * @param CharacterInterface $character
     * @return mixed
     */
    public function setCharacter(CharacterInterface $character);

    /**
     * @return CharacterInterface
     */
    public function getCharacter() : CharacterInterface;

    /**
     * @param TileInterface $tile
     * @return mixed
     */
    public function setTile(TileInterface $tile);

    /**
     * @return TileInterface
     */
    public function getTile() : TileInterface;
}
