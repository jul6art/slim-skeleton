<?php

namespace App\Infrastructure\Migrations;

use App\Infrastructure\Migrations\Interfaces\MigrationInterface;
use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use Illuminate\Database\Schema\Builder;

/**
 * Class AbstractMigration
 * @package App\Infrastructure\Migrations
 */
abstract class AbstractMigration implements MigrationInterface
{
    /**
     * @var Builder
     */
    protected $schema;

    /**
     * AbstractMigration constructor.
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->schema = $database->getCapsule()->getConnection()->getSchemaBuilder();
    }
}