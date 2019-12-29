<?php
declare(strict_types=1);

use App\Application\Command\DatabaseDropCommand;
use App\Application\Command\FixtureLoadCommand;
use App\Application\Command\SampleCommand;
use App\Infrastructure\Fixtures\UserFixtures;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'default_locale' => 'en',
            'project_dir' => __DIR__ . '/../',
            'translations_dir' => __DIR__ . '/../translations/',
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
            'skeleton:fixtures:load' => FixtureLoadCommand::class,
            'skeleton:sample' => SampleCommand::class,
        ],
        'fixtures' => [
            UserFixtures::class,
        ],
    ]);
};
