<?php

namespace AppBundle\Turn\Factory;

use AppBundle\Character\CharacterInterface;
use AppBundle\Turn\TurnInterface;
use AppBundle\World\TileInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class TurnFactory
 * @package AppBundle\Turn\Factory
 */
class TurnFactory
{
    /**
     * @var $supportedClass
     */
    protected $supportedClass;

    /**
     * TurnFactory constructor.
     * @param string $supportedClass
     * @throws \Exception
     */
    public function __construct(string $supportedClass)
    {
        if (!(is_subclass_of($supportedClass, TurnInterface::class))) {
            throw new \Exception(sprintf("\$supportedClass must be instance of '%s'", TurnInterface::class));
        }

        $this->supportedClass = $supportedClass;
    }

    /**
     * @param UuidInterface $uuid
     * @param CharacterInterface $character
     * @param TileInterface $tile
     * @return TurnInterface
     */
    public function createTurn(UuidInterface $uuid, CharacterInterface $character, TileInterface $tile) : TurnInterface
    {
        $turn = (new \ReflectionClass($this->supportedClass))->newInstanceArgs([$uuid]);
        $turn->setCharacter($character);
        $turn->setTile($tile);

        return $turn;
    }
}
