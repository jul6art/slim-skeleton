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
            'project_name' => 'Slim Skeleton',
            'default_locale' => 'en',
            'available_locales' => [
                'en',
                'fr',
            ],
            'project_dir' => __DIR__ . '/../',
            'templates_dir' => __DIR__ . '/../templates/',
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
            'email' => [
                'disable_delivery' => getenv('EMAIL_DISABLE_DELIVERY'),
                'host' => getenv('EMAIL_HOST'),
                'port' => getenv('EMAIL_PORT'),
                'from' => [
                    'address' => getenv('EMAIL_FROM_ADDRESS'),
                    'name' => getenv('EMAIL_FROM_NAME'),
                ],
                'debug' => [
                    getenv('EMAIL_DEBUG_ADDRESS'),
                ],
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
