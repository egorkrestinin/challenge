<?php

namespace AppBundle\Repository;

use AppBundle\World\TileInterface;
use AppBundle\World\WorldInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class TileRepository
 * @package AppBundle\Repository
 */
class TileRepository extends EntityRepository
{
    /**
     * @param WorldInterface $world
     * @return TileInterface
     */
    public function getRandomUnusedTileForTheWorld(WorldInterface $world) : TileInterface
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.characters', 'c')
            ->andWhere('t.world=:world')
            ->andWhere('c.id is null')
            ->setParameter('world', $world)
            ->groupBy('t')
            ->orderBy('rand()')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
