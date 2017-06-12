<?php

namespace AppBundle\CommandBus;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PersistEntityCommandHandler
 * @package AppBundle\CommandBus
 */
class PersistEntityCommandHandler
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * PersistEntityCommandHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param object $command
     */
    public function handle($command)
    {
        $this->entityManager->persist($command);
        $this->entityManager->flush();
    }
}
