<?php

namespace AppBundle\World;

/**
 * Interface WorldInterface
 * @package AppBundle\World
 */
interface WorldInterface
{
    /**
     * @return int
     */
    public function getWorldSizeX() : int;

    /**
     * @return int
     */
    public function getWorldSizeY() : int;

    /**
     * @param TileInterface $tile
     * @return mixed
     */
    public function addTile(TileInterface $tile);
}
