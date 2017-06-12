<?php

namespace AppBundle\Character;

use AppBundle\World\TileInterface;

/**
 * Interface CharacterInterface
 * @package AppBundle\Character
 */
interface CharacterInterface
{
    public const TYPE_PLAYER = 1;

    public const TYPE_NPC = 2;

    /**
     * @param int $health
     * @return mixed
     */
    public function setHealth(int $health);

    /**
     * @return int
     */
    public function getHealth() : int;

    /**
     * @param int $strength
     * @return mixed
     */
    public function setStrength(int $strength);

    /**
     * @return int
     */
    public function getStrength() : int;

    /**
     * @param string $name
     * @param $value
     * @return mixed
     */
    public function setAbility(string $name, $value);

    /**
     * @param string $name
     * @return mixed
     */
    public function getAbility(string $name);

    /**
     * @param string $name
     * @return bool
     */
    public function hasAbility(string $name) : bool;

    /**
     * @param TileInterface $tile
     * @return mixed
     */
    public function setWorldTile(TileInterface $tile);

    /**
     * @return TileInterface
     */
    public function getWorldTile() : TileInterface;

    /**
     * @return int
     */
    public function getType() : int;

    /**
     * @return int
     */
    public function getExperience() : int;

    /**
     * @param int $experience
     * @return mixed
     */
    public function setExperience(int $experience);
}
