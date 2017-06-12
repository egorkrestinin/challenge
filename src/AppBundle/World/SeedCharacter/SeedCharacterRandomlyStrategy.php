<?php

namespace AppBundle\World\SeedCharacter;

use AppBundle\Character\CharacterInterface;
use AppBundle\Repository\TileRepository;
use AppBundle\World\WorldInterface;

/**
 * Class SeedCharacterRandomlyStrategy
 * @package AppBundle\World\SeedCharacter
 */
class SeedCharacterRandomlyStrategy implements SeedCharacterStrategyInterface
{
    /**
     * @var TileRepository
     */
    protected $tileRepository;

    /**
     * SeedCharacterRandomlyStrategy constructor.
     * @param TileRepository $tileRepository
     */
    public function __construct(TileRepository $tileRepository)
    {
        $this->tileRepository = $tileRepository;
    }

    /**
     * @param WorldInterface $world
     * @param CharacterInterface $character
     */
    public function seed(WorldInterface $world, CharacterInterface $character)
    {
        $tile = $this->tileRepository->getRandomUnusedTileForTheWorld($world);
        $character->setWorldTile($tile);
    }
}
