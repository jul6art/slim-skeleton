<?php

namespace App\Domain\Repository\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interfaces RepositoryInterface
 * @package App\Infrastructure\Persistence
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;

    /**
     * @param array $filters
     * @return Model[]|Collection
     */
    public function findBy(array $filters = []): Collection;

    /**
     * @return Collection
     */
    public function findAll(): Collection;
}
