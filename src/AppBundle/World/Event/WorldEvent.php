<?php

namespace AppBundle\World\Event;

use AppBundle\World\WorldInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class WorldEvent
 * @package AppBundle\World\Event
 */
class WorldEvent extends Event
{
    public const ON_CREATED = 'app.world.world_event.on_created';

    /**
     * @var WorldInterface
     */
    protected $world;

    /**
     * WorldEvent constructor.
     * @param WorldInterface $world
     */
    public function __construct(WorldInterface $world)
    {
        $this->world = $world;
    }

    /**
     * @return WorldInterface
     */
    public function getWorld()
    {
        return $this->world;
    }
}
