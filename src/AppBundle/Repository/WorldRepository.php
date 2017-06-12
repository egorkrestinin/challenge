<?php

namespace AppBundle\Repository;

use AppBundle\World\WorldInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class WorldRepository
 * @package AppBundle\Repository
 */
class WorldRepository extends EntityRepository
{
    /**
     * @param WorldInterface $world
     */
    public function save(WorldInterface $world)
    {
        $this->getEntityManager()->persist($world);
        $this->getEntityManager()->flush();
    }
}
