<?php

namespace AppBundle\Entity;

use AppBundle\World\TileInterface;
use AppBundle\World\WorldInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

/**
 * Class World
 * @package AppBundle\Entity
 */
class World implements WorldInterface
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var int
     */
    protected $worldSizeX;

    /**
     * @var int
     */
    protected $worldSizeY;

    /**
     * @var TileInterface[]|ArrayCollection
     */
    protected $tiles;

    /**
     * Game constructor.
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
        $this->tiles = new ArrayCollection();
    }

    /**
     * @param int $worldSizeX
     */
    public function setWorldSizeX(int  $worldSizeX)
    {
        $this->worldSizeX = $worldSizeX;
    }

    /**
     * @return int
     */
    public function getWorldSizeX() : int
    {
        return $this->worldSizeX;
    }

    /**
     * @param int $worldSizeY
     */
    public function setWorldSizeY(int $worldSizeY)
    {
        $this->worldSizeY = $worldSizeY;
    }

    /**
     * @return int
     */
    public function getWorldSizeY() : int
    {
        return $this->worldSizeY;
    }

    /**
     * @param TileInterface $tile
     * @return $this
     * @throws \Exception
     */
    public function addTile(TileInterface $tile)
    {
        if ($tile->getX() >= $this->getWorldSizeX()) {
            throw new \Exception(
                sprintf("X position (%d) should be less than world size (%d)", $tile->getX(), $this->getWorldSizeX())
            );
        }

        if ($tile->getY() >= $this->getWorldSizeY()) {
            throw new \Exception(
                sprintf("Y position (%d) should be less than world size (%d)", $tile->getY(), $this->getWorldSizeY())
            );
        }

        $this->tiles->add($tile);
        $tile->setWorld($this);

        return $this;
    }
}
