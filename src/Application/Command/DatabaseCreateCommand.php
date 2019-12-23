<?php

namespace App\Application\Command;

use App\Infrastructure\Persistence\DatabaseInterface;
use Nette\Utils\Finder;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Class DatabaseCreateCommand
 * @package App\Application\Command
 */
class DatabaseCreateCommand implements CommandInterface
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

        $path = sprintf('%ssrc/Infrastructure/Migrations/', $this->container->get('settings')['project_dir']);
        foreach (Finder::findFiles('*.php')->in($path) as $key => $file) {
            if ($file->getFilename() !== 'AbstractMigration.php') {
                [$filename, $extension] = explode('.', $file->getFilename());
                $class = "App\\Infrastructure\\Migrations\\$filename";

                $migration = new $class($this->container->get(DatabaseInterface::class));
                $migration->up();
            }
        }

        return 'SUCCESS! Command successfully launched!';
    }
}