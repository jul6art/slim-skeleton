<?php

namespace App\Application\Services\Database;

use \PDO;
use \PDOStatement;
use stdClass;

/**
 * Class Database
 * @package App\Application\Services\Database
 */
class Database implements ConnectionInterface
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * @param PDO $connection
     * @return Database
     */
    public function setConnection(PDO $connection): Database
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * @inheritDoc
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * @inheritDoc
     */
    public function errorCode(): string
    {
        return $this->connection->errorCode();
    }

    /**
     * @inheritDoc
     */
    public function errorInfo(): array
    {
        return $this->connection->errorInfo();
    }

    /**
     * @inheritDoc
     */
    public function exec(string $statement): int
    {
        return $this->connection->exec($statement);
    }

    /**
     * @inheritDoc
     */
    public function inTransaction(): bool
    {
        return $this->connection->inTransaction();
    }

    /**
     * @inheritDoc
     */
    public function lastInsertId(string $name = null): string
    {
        return $this->connection->lastInsertId($name);
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $statement, array $driverOptions = []): PDOStatement
    {
        return $this->connection->prepare($statement, $driverOptions);
    }

    /**
     * @inheritDoc
     */
    public function query(string $statement): PDOStatement
    {
        return $this->connection->query($statement);
    }

    /**
     * @inheritDoc
     */
    public function quote(string $string, int $parameterType = PDO::PARAM_STR): string
    {
        return $this->connection->quote($string, $parameterType);
    }

    /**
     * @inheritDoc
     */
    public function rollBack(): bool
    {
        return $this->connection->rollBack();
    }

    /**
     * @param string $table
     * @param int $id
     * @return stdClass
     */
    public function find(string $table, int $id): stdClass
    {
        $query = $this->connection->prepare("SELECT * FROM $table WHERE id = $id");

        $query->execute();

        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param string $table
     * @return array
     */
    public function findAll(string $table): array
    {
        $query = $this->connection->prepare("SELECT * FROM $table");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}