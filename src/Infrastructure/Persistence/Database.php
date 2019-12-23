<?php

namespace App\Infrastructure\Persistence;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Database
 * @package App\Infrastructure\Persistence
 */
class Database implements DatabaseInterface
{
    /**
     * @var Capsule
     */
    private $capsule;

    public function __construct()
    {
        return $this->buildCapsule();
    }

    /**
     * @return Capsule
     */
    public function getCapsule(): Capsule
    {
        return $this->capsule;
    }

    /**
     * @param Capsule $capsule
     * @return Database
     */
    public function setCapsule(Capsule $capsule): DatabaseInterface
    {
        $this->capsule = $capsule;
        return $this;
    }

    public function buildCapsule(): void
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => getenv('DATABASE_HOST'),
            'database'  => getenv('DATABASE_NAME'),
            'username'  => getenv('DATABASE_USER'),
            'password'  => getenv('DATABASE_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();

        $this->setCapsule($capsule);
    }
}