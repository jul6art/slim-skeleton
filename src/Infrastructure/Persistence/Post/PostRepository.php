<?php


namespace App\Infrastructure\Persistence\Post;

use App\Application\Services\Database\ConnectionInterface;
use App\Infrastructure\Persistence\RepositoryInterface;
use stdClass;

/**
 * Class PostRepository
 * @package App\Infrastructure\Persistence\Post
 */
class PostRepository implements RepositoryInterface
{
    private const TABLE = 'post';

    /**
     * @var ConnectionInterface
     */
    private $database;

    /**
     * PostRepository constructor.
     * @param ConnectionInterface $database
     */
    public function __construct(ConnectionInterface $database)
    {
        $this->database = $database;
    }

    /**
     * @param int $id
     * @return stdClass
     */
    public function find(int $id): stdclass
    {
        return $this->database->find(self::TABLE, $id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->database->findAll(self::TABLE);
    }
}