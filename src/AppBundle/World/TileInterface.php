<?php

namespace AppBundle\World;

/**
 * Interface TileInterface
 * @package AppBundle\World
 */
interface TileInterface
{
    /**
     * @return int
     */
    public function getX() : int;

    /**
     * @return int
     */
    public function getY() : int;

    /**
     * @param WorldInterface $world
     * @return mixed
     */
    public function setWorld(WorldInterface $world);

    /**
     * @return WorldInterface
     */
    public function getWorld() : WorldInterface;
}
