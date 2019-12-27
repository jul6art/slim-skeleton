<?php

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder as Schema;

/**
 * Class Database
 * @package App\Infrastructure\Persistence
 */
class Database implements DatabaseInterface
{
    /**
     * @var Capsule
     */
    public $capsule;

    /**
     * @var Schema
     */
    public $schema;

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

    /**
     * @return Schema
     */
    public function getSchema(): Schema
    {
        return $this->schema;
    }

    /**
     * @param Schema $schema
     * @return Database
     */
    public function setSchema(Schema $schema): DatabaseInterface
    {
        $this->schema = $schema;
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
        $this->setSchema($capsule->schema());
    }
}