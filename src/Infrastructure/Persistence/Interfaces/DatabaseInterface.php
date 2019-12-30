<?php

namespace App\Infrastructure\Persistence\Interfaces;

use App\Infrastructure\Persistence\Database;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder as Schema;

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

    /**
     * @return Schema
     */
    public function getSchema(): Schema;

    /**
     * @param Schema $schema
     * @return Database
     */
    public function setSchema(Schema $schema): DatabaseInterface;

    public function buildCapsule(): void;
}
