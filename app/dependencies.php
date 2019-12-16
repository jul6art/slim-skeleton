<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use App\Application\Services\Database\ConnectionInterface;
use App\Application\Services\Database\Database;

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
            return new Twig('../templates', ['cache' => false]);
        },
    ]);

    $containerBuilder->addDefinitions([
        ConnectionInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $dbSettings = $settings['database'];

            $pdo = new \PDO("mysql:host=" . $dbSettings['host'] . ";dbname=" . $dbSettings['database'], $dbSettings['username'], $dbSettings['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return (new Database())->setConnection($pdo);
        },
    ]);
};
