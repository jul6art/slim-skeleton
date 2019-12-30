<?php

namespace App\Domain\Repository;

use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use App\Domain\Repository\Interfaces\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class AbstractRepository
 * @package App\Infrastructure\Repository
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var null|string
     */
    protected $model = null;

    /**
     * @var DatabaseInterface
     */
    private $database;

    /**
     * AbstractRepository constructor.
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * @return Model[]|Collection
     * @throws Exception
     */
    public function findAll(): Collection
    {
        if (null === $this->model) {
            throw new Exception("ERROR! You must provide a table name in your repository!");
        }

        return $this->model::query()->get();
    }

    /**
     * @param array $filters
     * @return Model[]|Collection
     * @throws Exception
     */
    public function findBy(array $filters = []): Collection
    {
        if (null === $this->model) {
            throw new Exception("ERROR! You must provide a table name in your repository!");
        }

        $builder = $this->model::query();

        foreach ($filters as $key => $value) {
            $builder->where($key, '=', $value);
        }

        return $builder->get();
    }

    /**
     * @param int $id
     * @return Model|null
     * @throws Exception
     */
    public function find(int $id): ?Model
    {
        if (null === $this->model) {
            throw new Exception("ERROR! You must provide a table name in your repository!");
        }

        return $this->model::query()
            ->where('id', '=', $id)
            ->get()
            ->first();
    }
}
