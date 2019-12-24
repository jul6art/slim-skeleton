<?php

namespace App\Application\Command;

use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Class DatabaseDropCommand
 * @package App\Application\Command
 */
class DatabaseDropCommand extends AbstractCommand
{
    /**
     * @var DatabaseInterface
     */
    protected $database;

    /**
     * DatabaseDropCommand constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->database = $this->container->get(DatabaseInterface::class);
    }

    /**
     * @param $args
     * @return int
     */
    public function command($args): int
    {
        $this->info('Dropping database');

        if (!empty($args)) {
            throw new RuntimeException("ERROR! Command takes no arguments");
        }

        $capsule = $this->database->getCapsule();

        foreach($capsule::select('SHOW TABLES') as $table){
            $capsule->getConnection()->getSchemaBuilder()->drop($table->Tables_in_slim_skeleton);
            $this->write("Table {$table->Tables_in_slim_skeleton} deleted.");
        }

        $this->success('Database successfully dropped!');

        return 0;
    }
}