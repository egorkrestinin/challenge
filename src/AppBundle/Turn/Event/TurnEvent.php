<?php

namespace AppBundle\Turn\Event;

use AppBundle\Turn\TurnInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class TurnEvent
 * @package AppBundle\Turn\Event
 */
class TurnEvent extends Event
{
    const BEFORE_CREATED = 'app.turn.event.before_created';
    const AFTER_CREATED = 'app.turn.event.after_created';

    /**
     * @var TurnInterface
     */
    protected $turn;

    /**
     * TurnEvent constructor.
     * @param TurnInterface $turn
     */
    public function __construct(TurnInterface $turn)
    {
        $this->turn = $turn;
    }

    /**
     * @return TurnInterface
     */
    public function getTurn() : TurnInterface
    {
        return $this->turn;
    }
}
