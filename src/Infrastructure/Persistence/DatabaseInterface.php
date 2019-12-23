<?php

namespace App\Infrastructure\Persistence;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Interface DatabaseInterface
 * @package App\Infrastructure\Persistence
 */
interface DatabaseInterface
{
    /**
     * @return Capsule
     */
    public function getCapsule(): Capsule;

    /**
     * @param Capsule $capsule
     * @return Database
     */
    public function setCapsule(Capsule $capsule): DatabaseInterface;

    public function buildCapsule(): void;
}