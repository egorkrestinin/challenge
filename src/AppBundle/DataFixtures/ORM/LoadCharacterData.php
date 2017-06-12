<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Character\Command\CreateCharacterCommand;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class LoadCharacterData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $command = new CreateCharacterCommand();
        $command->setId(Uuid::fromString('968ad663-4e4d-4719-8fc7-af72ff931909'));
        $command->setPrototype('warrior');
        $this->container->get('tactician.commandbus')->handle($command);
    }

    public function getOrder()
    {
        return 0;
    }
}
