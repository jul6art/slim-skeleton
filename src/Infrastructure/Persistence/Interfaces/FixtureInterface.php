<?php

namespace App\Infrastructure\Persistence\Interfaces;

use Faker\Generator;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder as Schema;
use Psr\Container\ContainerInterface;

/**
 * Interfaces FixtureInterface
 * @package App\Infrastructure\Migrations\Interfaces
 */
interface FixtureInterface
{
    public function load(): void;

    /**
     * @return Capsule
     */
    public function getCapsule(): Capsule;

    /**
     * @return Schema
     */
    public function getSchema(): Schema;

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface;

    /**
     * @return Generator
     */
    public function getFaker(): Generator;
}