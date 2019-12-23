<?php

namespace App\Application\Command;

use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Class SampleCommand
 * @package App\Application\Command
 */
class SampleCommand implements CommandInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * SampleCommand constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $args
     * @return mixed
     */
    public function command($args)
    {
        // Access items in container
        $settings = $this->container->get('settings');

        // Throw if no arguments provided
        if (empty($args)) {
            throw new RuntimeException("No arguments passed to command");
        }

        $firstArg = $args[0];

        // Output the first argument
        return $firstArg;
    }
}