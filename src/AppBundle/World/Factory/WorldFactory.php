<?php

namespace AppBundle\World\Factory;

use AppBundle\Entity\Tile;
use AppBundle\World\WorldInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class WorldFactory
 * @package AppBundle\World\Factory
 */
class WorldFactory
{
    /**
     * @var $supportedClass
     */
    protected $supportedClass;

    /**
     * @var int
     */
    protected $sizeX;

    /**
     * @var int
     */
    protected $sizeY;

    /**
     * WorldFactory constructor.
     * @param string $supportedClass
     * @param int $sizeX
     * @param int $sizeY
     * @throws \Exception
     */
    public function __construct(string $supportedClass, int $sizeX, int $sizeY)
    {
        if (!(is_subclass_of($supportedClass, WorldInterface::class))) {
            throw new \Exception(sprintf("\$supportedClass must be instance of '%s'", WorldInterface::class));
        }
        $this->supportedClass = $supportedClass;
        $this->sizeX = $sizeX;
        $this->sizeY = $sizeY;
    }

    /**
     * @param UuidInterface $uuid
     * @return WorldInterface
     */
    public function createWorld(UuidInterface $uuid) : WorldInterface
    {
        $world = (new \ReflectionClass($this->supportedClass))->newInstanceArgs([$uuid]);
        $world->setWorldSizeX($this->sizeX);
        $world->setWorldSizeY($this->sizeY);
        $this->populateWorldWithTiles($world);

        return $world;
    }

    /**
     * @param WorldInterface $world
     */
    //TODO: it breaks SR principle, but unfortunately I have no time to change it :(
    protected function populateWorldWithTiles(WorldInterface $world)
    {
        foreach (range(0, $this->sizeX - 1) as $x) {
            foreach (range(0, $this->sizeY - 1) as $y) {
                $tile = new Tile(Uuid::uuid4(), $x, $y);
                $world->addTile($tile);
            }
        }
    }
}
