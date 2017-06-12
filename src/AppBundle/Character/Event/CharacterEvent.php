<?php

namespace AppBundle\Character\Event;

use AppBundle\Character\CharacterInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CharacterEvent
 * @package AppBundle\Character\Event
 */
class CharacterEvent extends Event
{
    const ON_CREATED = 'app.character.event.on_created';
    const ON_MOVED = 'app.character.event.on_moved';

    /**
     * @var CharacterInterface
     */
    protected $character;

    /**
     * CharacterEvent constructor.
     * @param CharacterInterface $character
     */
    public function __construct(CharacterInterface $character)
    {
        $this->character = $character;
    }

    /**
     * @return CharacterInterface
     */
    public function getCharacter() : CharacterInterface
    {
        return $this->character;
    }
}
