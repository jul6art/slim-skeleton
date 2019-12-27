<?php

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Persistence\Interfaces\MigrationInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder as Schema;
use Phinx\Migration\AbstractMigration as BaseMigration;

/**
 * Class AbstractMigration
 * @package App\Infrastructure\Migrations
 */
abstract class AbstractMigration extends BaseMigration implements MigrationInterface
{
    /**
     * @var Capsule
     */
    public $capsule;

    /**
     * @var Schema
     */
    public $schema;

    public function init()
    {
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => getenv('DATABASE_HOST'),
            'database'  => getenv('DATABASE_NAME'),
            'username'  => getenv('DATABASE_USER'),
            'password'  => getenv('DATABASE_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}