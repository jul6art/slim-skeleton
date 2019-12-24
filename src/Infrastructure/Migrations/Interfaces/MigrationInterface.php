<?php

namespace App\Infrastructure\Migrations\Interfaces;

/**
 * Interfaces MigrationInterface
 * @package App\Infrastructure\Migrations\Interfaces
 */
interface MigrationInterface
{
    public function up(): void;
    public function down(): void;
}