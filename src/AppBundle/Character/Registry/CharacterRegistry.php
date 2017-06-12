<?php

namespace AppBundle\Character\Registry;

use AppBundle\Character\Prototype\CharacterPrototype;

/**
 * Class CharacterRegistry
 * @package AppBundle\Character\Registry
 */
class CharacterRegistry
{
    /**
     * @var CharacterPrototype[]
     */
    protected $prototypes;

    /**
     * @param string $alias
     * @param CharacterPrototype $characterPrototype
     */
    public function addPrototype(string $alias, CharacterPrototype $characterPrototype) : void
    {
        $this->prototypes[$alias] = $characterPrototype;
    }

    /**
     * @param string $alias
     * @return CharacterPrototype
     * @throws \Exception
     */
    public function getPrototype(string $alias) : CharacterPrototype
    {
        if (!isset($this->prototypes[$alias])) {
            throw new \Exception(sprintf("Unknown prototype '%s'", $alias));
        }

        return $this->prototypes[$alias];
    }

    /**
     * @return array
     */
    public function getAliases() : array
    {
        return array_keys($this->prototypes);
    }
}
