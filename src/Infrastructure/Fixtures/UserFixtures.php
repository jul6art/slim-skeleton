<?php

namespace App\Infrastructure\Fixtures;

use App\Domain\Constants\TableName;
use App\Infrastructure\Persistence\AbstractFixture;

/**
 * Class UserFixtures
 * @package App\Infrastructure\Fixtures
 */
class UserFixtures extends AbstractFixture
{
    public function load(): void
    {
        $limit = 100;

        for ($i = 0; $i < $limit; $i ++) {
            $this->capsule->table(TableName::TABLE_NAME_USER)->insert([
                'firstName' => $this->faker->firstName,
                'lastName' => $this->faker->lastName,
                'email' => $this->faker->unique()->safeEmail,
                'password' => 'test',
            ]);
        }
    }
}
