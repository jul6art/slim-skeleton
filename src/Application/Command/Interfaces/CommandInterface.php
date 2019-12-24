<?php

namespace App\Application\Command\Interfaces;

/**
 * Interfaces CommandInterface
 * @package App\Application\Command\Interfaces
 */
interface CommandInterface
{
    /**
     * @param $args
     * @return int
     */
    public function command($args): int;
}