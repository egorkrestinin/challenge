<?php

namespace AppBundle\Character\Command;

use AppBundle\Character\CharacterInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class CreateCharacterCommand
 * @package AppBundle\Character\Command
 */
class CreateCharacterCommand
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var string
     */
    protected $prototype;

    /**
     * @return null|UuidInterface
     */
    public function getId() : ?UuidInterface
    {
        return $this->id;
    }

    /**
     * @param UuidInterface $id
     * @return $this
     */
    public function setId(UuidInterface $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrototype() : ?string
    {
        return $this->prototype;
    }

    /**
     * @param string $prototype
     * @return $this
     */
    public function setPrototype(string $prototype)
    {
        $this->prototype = $prototype;

        return $this;
    }

    /**
     * @return int
     */
    public function getType() : int
    {
        return CharacterInterface::TYPE_PLAYER;
    }

}
