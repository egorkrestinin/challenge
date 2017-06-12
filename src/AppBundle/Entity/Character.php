<?php

namespace AppBundle\Entity;

use AppBundle\Character\CharacterInterface;
use AppBundle\World\TileInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Character
 * @package AppBundle\Entity
 */
class Character implements CharacterInterface
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var int
     */
    protected $health;

    /**
     * @var int
     */
    protected $strength;

    /**
     * @var array
     */
    protected $abilities = [];

    /**
     * @var int
     */
    protected $type;

    /**
     * @var TileInterface
     */
    protected $tile;

    /**
     * @var int
     */
    protected $experience;

    /**
     * Character constructor.
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id, int $type)
    {
        $this->id = $id;
        $this->type = $type;
        $this->experience = 0;
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $health
     * @return $this
     */
    public function setHealth(int $health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * @return int
     */
    public function getHealth() : int
    {
        return $this->health;
    }

    /**
     * @param int $strength
     * @return $this
     */
    public function setStrength(int $strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * @return int
     */
    public function getStrength() : int
    {
        return $this->strength;
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function setAbility(string $name, $value)
    {
        if (!is_scalar($value)) {
            throw new \Exception("Value must be scalar");
        }

        $this->abilities[$name] = $value;

        return$this;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function getAbility(string $name)
    {
        if (!$this->hasAbility($name)) {
            throw new \Exception(sprintf("Character has no ability '%s'", $name));
        }

        return $this->abilities[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasAbility(string $name) : bool
    {
        return isset($this->abilities[$name]);
    }

    /**
     * @param TileInterface $tile
     * @return $this
     */
    public function setWorldTile(TileInterface $tile)
    {
        if ($this->tile && $this->tile->getWorld() !== $tile->getWorld()) {
            throw new \LogicException("Tile must belong to the same world");
        }

        $this->tile = $tile;

        return $this;
    }

    /**
     * @return TileInterface
     */
    public function getWorldTile() : TileInterface
    {
        return $this->tile;
    }

    /**
     * @return int
     */
    public function getType() : int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getExperience() : int
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     * @return $this
     */
    public function setExperience(int $experience)
    {
        $this->experience = $experience;

        return $this;
    }
}
