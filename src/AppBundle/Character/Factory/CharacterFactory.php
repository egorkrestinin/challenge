<?php

namespace AppBundle\Character\Factory;

use App\CharacterBundle\Entity\Character;
use AppBundle\Character\CharacterInterface;
use AppBundle\Character\Entity;
use AppBundle\Character\Event\CharacterEvent;
use AppBundle\Character\Registry\CharacterRegistry;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CharacterFactory
 * @package AppBundle\Character\Factory
 */
class CharacterFactory
{
    /**
     * @var CharacterRegistry
     */
    protected $characterRegistry;

    /**
     * CharacterFactory constructor.
     * @param CharacterRegistry $characterRegistry
     */
    public function __construct(CharacterRegistry $characterRegistry)
    {
        $this->characterRegistry = $characterRegistry;
    }

    /**
     * @param string $prototypeAlias
     * @param UuidInterface $id
     * @param int $type
     * @return CharacterInterface
     * @throws \Exception
     */
    public function createCharacter(string $prototypeAlias, UuidInterface $id, int $type) : CharacterInterface
    {
        $prototype = $this->characterRegistry->getPrototype($prototypeAlias);

        $character = (new \ReflectionClass($prototype->getSupportedClass()))->newInstanceArgs([$id, $type]);
        if (!$character instanceof CharacterInterface) {
            throw new \Exception(sprintf("Character must be instance of '%s'", CharacterInterface::class));
        }
        $character->setHealth($prototype->getHealth());
        $character->setStrength($prototype->getStrength());
        foreach ($prototype->getAbilities() as $name => $value) {
            $character->setAbility($name, $value);
        }

        return $character;
    }
}
