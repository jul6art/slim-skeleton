<?php

namespace App\Application\Command;

use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Class FixtureLoadCommand
 * @package App\Application\Command
 */
class FixtureLoadCommand extends AbstractCommand
{
    /**
     * @param $args
     * @return int
     * @throws ReflectionException
     */
    public function command($args): int
    {
        $this->info('Fixtures loading');

        if (!empty($args)) {
            throw new RuntimeException("ERROR! Command takes no arguments");
        }

        foreach ($this->container->get('fixtures') as $class) {
            $fixtureClass = new ReflectionClass($class);

            if (!$fixtureClass->hasMethod('load')) {
                throw new RuntimeException(sprintf('Fixture %s does not have a load() method', $fixtureClass));
            }

            $fixture = $fixtureClass->newInstanceArgs([$this->container]);
            $fixture->load();

            $this->write("Class $class read.");
        }


        $this->success('Fixtures successfully loaded!');

        return 0;
    }
}
