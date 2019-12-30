<?php

namespace App\Application\Command;

use App\Application\Command\Interfaces\CommandInterface;
use App\Application\Command\Traits\CommandLineTrait;
use Psr\Container\ContainerInterface;

/**
 * Class AbstractCommand
 * @package App\Application\Command
 */
abstract class AbstractCommand implements CommandInterface
{
    use CommandLineTrait;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * AbstractCommand constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
