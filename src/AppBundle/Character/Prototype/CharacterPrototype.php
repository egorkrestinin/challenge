<?php

namespace AppBundle\Character\Prototype;
use AppBundle\Character\CharacterInterface;

/**
 * Class CharacterPrototype
 * @package AppBundle\Character\Prototype
 */
class CharacterPrototype
{
    /**
     * @var array
     */
    protected $abilities = [];

    /**
     * @var int
     */
    protected $health;

    /**
     * @var int
     */
    protected $strength;

    /**
     * @var string
     */
    protected $supportedClass;

    /**
     * CharacterPrototype constructor.
     * @param string $supportedClass
     * @param int $health
     * @param int $strength
     * @throws \Exception
     */
    public function __construct(string $supportedClass, int $health, int $strength)
    {
        if (!is_subclass_of($supportedClass, CharacterInterface::class)) {
            throw new \Exception(sprintf("\$supportedClass must be an instance of '%s'", CharacterInterface::class));
        }

        $this->health = $health;
        $this->strength = $strength;
        $this->supportedClass = $supportedClass;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function setAbility(string $name, $value)
    {
        $this->abilities[$name] = $value;
    }

    /**
     * @return array
     */
    public function getAbilities() : array
    {
        return $this->abilities;
    }

    /**
     * @return int
     */
    public function getHealth() : int
    {
        return $this->health;
    }

    /**
     * @return int
     */
    public function getStrength() : int
    {
        return $this->strength;
    }

    /**
     * @return string
     */
    public function getSupportedClass() : string
    {
        return $this->supportedClass;
    }
}
