<?php


namespace App\Infrastructure\Persistence;

use stdClass;

/**
 * Interface RepositoryInterface
 * @package App\Infrastructure\Persistence
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @return stdClass
     */
    public function find(int $id): stdclass;

    /**
     * @return array
     */
    public function findAll(): array;
}
