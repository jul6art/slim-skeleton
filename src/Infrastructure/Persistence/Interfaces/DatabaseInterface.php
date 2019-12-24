<?php

namespace App\Infrastructure\Persistence\Interfaces;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Interfaces DatabaseInterface
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
     * @return DatabaseInterface
     */
    public function setCapsule(Capsule $capsule): DatabaseInterface;

    public function buildCapsule(): void;
}