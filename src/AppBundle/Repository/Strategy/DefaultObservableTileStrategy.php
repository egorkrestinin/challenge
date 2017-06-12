<?php

namespace AppBundle\Repository\Strategy;

use AppBundle\Character\CharacterInterface;
use AppBundle\Repository\TileRepository;
use AppBundle\World\TileInterface;

/**
 * Class DefaultObservableTileStrategy
 * @package AppBundle\Repository\Strategy
 */
class DefaultObservableTileStrategy implements ObservableTileStrategyInterface
{
    /**
     * @var TileRepository
     */
    protected $tileRepository;

    /**
     * @var int
     */
    protected $radius;

    /**
     * DefaultObservableTileStrategy constructor.
     * @param TileRepository $tileRepository
     * @param int $radius
     * @throws \Exception
     */
    public function __construct(TileRepository $tileRepository, int $radius)
    {
        if ($radius < 0) {
            throw new \Exception("\$radius must be non-negative");
        }

        $this->tileRepository = $tileRepository;
        $this->radius = $radius;
    }

    /**
     * @param CharacterInterface $character
     * @return TileInterface[]
     */
    public function getObservableTiles(CharacterInterface $character)
    {
        $tile = $character->getWorldTile();

        return $this->tileRepository->createQueryBuilder('t')
            ->andWhere('t.world=:world')
            ->andWhere('t.x between :min_x and :max_x')
            ->andWhere('t.y between :min_y and :max_y')
            ->setParameter('world', $tile->getWorld())
            ->setParameter('min_x', $tile->getX() - $this->radius)
            ->setParameter('max_x', $tile->getX() + $this->radius)
            ->setParameter('min_y', $tile->getY() - $this->radius)
            ->setParameter('max_y', $tile->getY() + $this->radius)
            ->addOrderBy('t.x', 'ASC')
            ->addOrderBy('t.y', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
