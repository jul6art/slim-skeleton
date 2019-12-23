<?php

namespace App\Infrastructure\Migrations\Interfaces;

/**
 * Interface MigrationInterface
 * @package App\Infrastructure\Migrations\Interfaces
 */
interface MigrationInterface
{
    public function up();
    public function down();
}