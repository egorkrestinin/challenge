<?php

namespace Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, KernelAwareContext
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @BeforeScenario @dbclean
     */
    public function startServer(BeforeScenarioScope $scope)
    {
        $app = new Application($this->kernel);
        $app->setAutoExit(false);
        $input = new ArrayInput(
            [
                'command' => 'doctrine:database:drop',
                '--force' => true,
                '-e' => 'test',
            ]
        );
        $app->run($input);
        $input = new ArrayInput(
            [
                'command' => 'doctrine:database:create',
                '-e' => 'test',
            ]
        );
        $app->run($input);
        $input = new ArrayInput(
            [
                'command' => 'doctrine:migrations:migrate',
                '-e' => 'test',
                '--no-interaction' => true,
                '-q'
            ]
        );
        $app->run($input);
        $input = new ArrayInput(
            [
                'command' => 'doctrine:fixtures:load',
                '-e' => 'test',
                '--no-interaction' => true,
                '-q'
            ]
        );
        $app->run($input);
    }
}
