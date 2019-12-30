<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;

/**
 * Class UserRepository
 * @package App\Infrastructure\Repository
 */
class UserRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected $model = User::class;
}
