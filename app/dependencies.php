<?php
declare(strict_types=1);

use App\Infrastructure\Persistence\Database;
use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
    ]);

    $containerBuilder->addDefinitions([
        Twig::class => function (ContainerInterface $c) {
            return new Twig($c->get('settings')['project_dir'] . 'templates', ['cache' => false]);
        },
    ]);

    $containerBuilder->addDefinitions([
        DatabaseInterface::class => function (ContainerInterface $c) {
            return new Database();
        },
    ]);
};
