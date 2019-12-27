<?php

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use App\Infrastructure\Persistence\Interfaces\FixtureInterface;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder as Schema;
use Psr\Container\ContainerInterface;

/**
 * Class AbstractFixture
 * @package App\Infrastructure\Persistence
 */
abstract class AbstractFixture implements FixtureInterface
{
    /**
     * @var Capsule
     */
    protected $capsule;

    /**
     * @var Schema
     */
    protected $schema;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Generator
     */
    protected $faker;

    /**
     * AbstractFixture constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $database = $container->get(DatabaseInterface::class);
        $this->capsule = $database->getCapsule();
        $this->schema = $database->getSchema();
        $this->container = $container;
        $this->faker = (new Factory())::create($container->get('settings')['default_locale']);
    }

    /**
     * @return Capsule
     */
    public function getCapsule(): Capsule
    {
        return $this->capsule;
    }

    /**
     * @return Schema
     */
    public function getSchema(): Schema
    {
        return $this->schema;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return Generator
     */
    public function getFaker(): Generator
    {
        return $this->faker;
    }
}
