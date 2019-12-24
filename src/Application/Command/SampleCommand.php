<?php

namespace App\Application\Command;

use RuntimeException;

/**
 * Class SampleCommand
 * @package App\Application\Command
 */
class SampleCommand extends AbstractCommand
{
    /**
     * @param $args
     * @return int
     */
    public function command($args): int
    {
        $this->info('Creating sample');

        // Access items in container
        $settings = $this->container->get('settings');

        // Throw if no arguments provided
        if (empty($args)) {
            throw new RuntimeException("ERROR! No arguments passed to command");
        }

        $this->write("Argument 0: {$args[0]}");

        $this->success('Sample successfully created');

        return 0;
    }
}