<?php

namespace AppBundle\Turn\Command;

use AppBundle\Character\CharacterInterface;
use AppBundle\World\TileInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class CreateTurnCommand
 * @package AppBundle\Turn\Command
 */
class CreateTurnCommand
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
     * @var $character
     */
    protected $character;

    /**
     * @return null|UuidInterface
     */
    public function getId() : ?UuidInterface
    {
        return $this->id;
    }

    /**
     * @param UuidInterface $id
     * @return $this
     */
    public function setId(UuidInterface $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return TileInterface|null
     */
    public function getTile() : ?TileInterface
    {
        return $this->tile;
    }

    /**
     * @param TileInterface $tile
     * @return $this
     */
    public function setTile(TileInterface $tile)
    {
        $this->tile = $tile;

        return $this;
    }

    /**
     * @return CharacterInterface|null
     */
    public function getCharacter() : ?CharacterInterface
    {
        return $this->character;
    }

    /**
     * @param CharacterInterface $character
     * @return $this
     */
    public function setCharacter(CharacterInterface $character)
    {
        $this->character = $character;

        return $this;
    }
}
