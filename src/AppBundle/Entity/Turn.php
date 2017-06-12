<?php

namespace AppBundle\Entity;

use AppBundle\Character\CharacterInterface;
use AppBundle\Turn\TurnInterface;
use AppBundle\World\TileInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Turn
 * @package AppBundle\Entity
 */
class Turn implements TurnInterface
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var TileInterface
     */
    protected $tile;

    /**
     * @var CharacterInterface
     */
    protected $character;

    /**
     * Turn constructor.
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @param TileInterface $tile
     * @return $this
     */
    public function setTile(TileInterface $tile)
    {
        $this->tile = $tile;
        if ($this->character) {
            $this->character->setWorldTile($this->tile);
        }

        return $this;
    }

    /**
     * @return TileInterface
     */
    public function getTile() : TileInterface
    {
        return $this->tile;
    }

    /**
     * @param CharacterInterface $character
     * @return $this
     */
    public function setCharacter(CharacterInterface $character)
    {
        $this->character = $character;
        if ($this->tile) {
            $this->character->setWorldTile($this->tile);
        }

        return $this;
    }

    /**
     * @return CharacterInterface
     */
    public function getCharacter() : CharacterInterface
    {
        return $this->character;
    }
}
