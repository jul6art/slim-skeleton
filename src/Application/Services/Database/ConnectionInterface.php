<?php

namespace App\Application\Services\Database;

use PDO;
use PDOStatement;
use stdClass;

/**
 * Interface ConnectionInterface
 * @package App\Application\Services\Database
 */
interface ConnectionInterface
{
    /**
     * @return bool
     */
    public function beginTransaction(): bool;

    /**
     * @return bool
     */
    public function commit(): bool;

    /**
     * @return string
     */
    public function errorCode(): string;

    /**
     * @return array
     */
    public function errorInfo(): array;

    /**
     * @param string $statement
     * @return int
     */
    public function exec(string $statement): int;

    /**
     * @return bool
     */
    public function inTransaction(): bool;

    /**
     * @param string|null $name
     * @return string
     */
    public function lastInsertId(string $name = null): string;

    /**
     * @param string $statement
     * @param array $driverOptions
     * @return PDOStatement
     */
    public function prepare(string $statement, array $driverOptions = []): PDOStatement;

    /**
     * @param string $statement
     * @return PDOStatement
     */
    public function query(string $statement): PDOStatement;

    /**
     * @param string $string
     * @param int $parameterType
     * @return string
     */
    public function quote(string $string, int $parameterType = PDO::PARAM_STR): string;

    /**
     * @return bool
     */
    public function rollBack(): bool;

    /**
     * @param string $table
     * @param int $id
     * @return stdClass
     */
    public function find(string $table, int $id): stdClass;

    /**
     * @param string $table
     * @return array
     */
    public function findAll(string $table): array;
}
