<?php
declare(strict_types=1);

use App\Application\Command\DatabaseCreateCommand;
use App\Application\Command\DatabaseDropCommand;
use App\Application\Command\SampleCommand;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'project_dir' => __DIR__ . '/../',
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-skeleton',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'database' => [
                'host' => getenv('DATABASE_HOST'),
                'port' => getenv('DATABASE_PORT'),
                'database' => getenv('DATABASE_NAME'),
                'username' => getenv('DATABASE_USER'),
                'password' => getenv('DATABASE_PASSWORD'),
            ],
        ],
        'commands' => [
            'skeleton:database:drop' => DatabaseDropCommand::class,
            'skeleton:sample' => SampleCommand::class,
        ],
    ]);
};
