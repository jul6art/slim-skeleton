<?php

namespace App\Infrastructure\Persistence\Interfaces;

/**
 * Interfaces RepositoryInterface
 * @package App\Infrastructure\Persistence
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @return iterable
     */
    public function findAll(): iterable;
}
