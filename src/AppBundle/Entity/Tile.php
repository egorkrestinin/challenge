<?php

namespace AppBundle\Entity;

use AppBundle\Character\CharacterInterface;
use AppBundle\World\TileInterface;
use AppBundle\World\WorldInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Tile
 * @package AppBundle\Entity
 */
class Tile implements TileInterface
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var int
     */
    protected $x;

    /**
     * @var int
     */
    protected $y;

    /**
     * @var WorldInterface
     */
    protected $world;

    /**
     * @var CharacterInterface[]|ArrayCollection
     */
    protected $characters;

    /**
     * Tile constructor.
     * @param UuidInterface $id
     * @param int $x
     * @param int $y
     */
    public function __construct(UuidInterface $id, int $x, int $y)
    {
        $this->id = $id;
        $this->x = $x;
        $this->y = $y;
        $this->characters = new ArrayCollection();
    }

    /**
     * @param int $x
     * @return $this
     */
    public function setX(int $x)
    {
        if ($this->x && $this->x !== $x) {
            throw new \LogicException("Value can't be overrider");
        }

        $this->x = $x;

        return $this;
    }

    /**
     * @return int
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * @param int $y
     * @return $this
     */
    public function setY(int $y)
    {
        if ($this->y && $this->y !== $y) {
            throw new \LogicException("Value can't be overrider");
        }

        $this->y = $y;

        return $this;
    }

    /**
     * @return int
     */
    public function getY() : int
    {
        return $this->y;
    }

    /**
     * @param WorldInterface $world
     * @return $this
     */
    public function setWorld(WorldInterface $world)
    {
        if ($this->world && $this->world !== $world) {
            throw new \LogicException("Value can't be overrider");
        }

        $this->world = $world;

        return $this;
    }

    /**
     * @return WorldInterface
     */
    public function getWorld() : WorldInterface
    {
        return $this->world;
    }

    /**
     * @return CharacterInterface[]|ArrayCollection
     */
    public function getCharacters()
    {
        return $this->characters;
    }
}
