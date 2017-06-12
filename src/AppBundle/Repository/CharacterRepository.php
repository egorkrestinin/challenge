<?php

namespace AppBundle\Repository;

use AppBundle\Character\CharacterInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class CharacterRepository
 * @package AppBundle\Repository
 */
class CharacterRepository extends EntityRepository
{
    /**
     * @return Query
     */
    public function getFindAllNonNPCQuery() : Query
    {
        return $this->getAliveCharacterQueryBuilder()
            ->andWhere('c.type != :type')
            ->setParameter('type', CharacterInterface::TYPE_NPC)
            ->getQuery();
    }

    /**
     * @param CharacterInterface $character
     * @return CharacterInterface[]
     */
    public function getAllEnemiesOnCharacterTile(CharacterInterface $character)
    {
        return $this->getAliveCharacterQueryBuilder()
            ->andWhere('c != :character')
            ->andWhere('c.tile = :tile')
            ->setParameter('character', $character)
            ->setParameter('tile', $character->getWorldTile())
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param string $id
     * @return CharacterInterface
     */
    public function findNonNPC(string $id) : ?CharacterInterface
    {
        try {
            return $this->getAliveCharacterQueryBuilder()
                ->andWhere('c.id=:id')
                ->andWhere('c.type != :type')
                ->setParameter('id', $id)
                ->setParameter('type', CharacterInterface::TYPE_NPC)
                ->getQuery()
                ->getSingleResult();
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param CharacterInterface $character
     */
    public function save(CharacterInterface $character)
    {
        $this->getEntityManager()->persist($character);
        $this->getEntityManager()->flush();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getAliveCharacterQueryBuilder()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.health > 0')
        ;
    }
}
