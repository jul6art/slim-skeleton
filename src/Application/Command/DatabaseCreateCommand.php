<?php

namespace App\Application\Command;

use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use Nette\Utils\Finder;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Class DatabaseCreateCommand
 * @package App\Application\Command
 */
class DatabaseCreateCommand extends AbstractCommand
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
     * @throws ReflectionException
     */
    public function command($args): int
    {
        $this->info('Creating database');

        if (!empty($args)) {
            throw new RuntimeException("ERROR! Command takes no arguments");
        }

        $path = sprintf('%ssrc/Infrastructure/Migrations/', $this->container->get('settings')['project_dir']);
        foreach (Finder::findFiles('*.php')->in($path) as $key => $file) {
            if ($file->getFilename() !== 'AbstractMigration.php') {
                $filename = explode('.', $file->getFilename())[0];
                $class = "App\Infrastructure\Migrations\\$filename";
                $migrationClass = new ReflectionClass($class);

                if (!$migrationClass->hasMethod('up')) {
                    throw new RuntimeException(sprintf('Migration %s does not have a up() method', $migrationClass));
                }

                $migration = $migrationClass->newInstanceArgs([$this->database]);
                $migration->up();

                $this->write("Migration $filename executed.");
            }
        }

        $this->success('Database successfully created!');

        return 0;
    }
}