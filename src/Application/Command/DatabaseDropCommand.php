<?php

namespace App\Application\Command;

use App\Infrastructure\Persistence\DatabaseInterface;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Class DatabaseDropCommand
 * @package App\Application\Command
 */
class DatabaseDropCommand implements CommandInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var DatabaseInterface
     */
    private $database;

    /**
     * DatabaseDropCommand constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->database = $this->container->get(DatabaseInterface::class);
    }

    /**
     * @param $args
     * @return mixed
     */
    public function command($args)
    {
        if (!empty($args)) {
            throw new RuntimeException("ERROR! Command takes no arguments");
        }

        $db = $this->database->getCapsule();
        $tables = $db::select('SHOW TABLES');
        foreach($tables as $table){
            $db->getConnection()->getSchemaBuilder()->drop($table->Tables_in_slim_skeleton);
            echo "Table {$table->Tables_in_slim_skeleton} deleted." . PHP_EOL;
        }

        return 'SUCCESS! Command successfully launched!';
    }
}