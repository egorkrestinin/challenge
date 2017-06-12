<?php

namespace AppBundle\Fight\Event;

use AppBundle\Character\CharacterInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FightResultEvent
 * @package AppBundle\Fight\Event
 */
class FightResultEvent extends Event
{
    public const ON_FIGHT = 'app.fight.fight_result_event.on_fight';

    /**
     * @var CharacterInterface
     */
    protected $winner;

    /**
     * @var CharacterInterface
     */
    protected $looser;

    /**
     * FightResultEvent constructor.
     * @param CharacterInterface $winner
     * @param CharacterInterface $looser
     */
    public function __construct(CharacterInterface $winner, CharacterInterface $looser)
    {
        $this->winner = $winner;
        $this->looser = $looser;
    }

    /**
     * @return CharacterInterface
     */
    public function getWinner() : CharacterInterface
    {
        return $this->winner;
    }

    /**
     * @return CharacterInterface
     */
    public function getLooser() : CharacterInterface
    {
        return $this->looser;
    }
}
