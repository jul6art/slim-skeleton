<?php

namespace App\Infrastructure\Persistence\Interfaces;

/**
 * Interfaces MigrationInterface
 * @package App\Infrastructure\Migrations\Interfaces
 */
interface MigrationInterface
{
    public function up(): void;
    public function down(): void;
}