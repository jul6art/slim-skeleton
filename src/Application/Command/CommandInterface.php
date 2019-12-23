<?php

namespace App\Application\Command;

/**
 * Interface CommandInterface
 * @package App\Application\Command
 */
interface CommandInterface
{
    /**
     * @param $args
     * @return mixed
     */
    public function command($args);
}