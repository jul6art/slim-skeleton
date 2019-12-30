<?php
declare(strict_types=1);

use App\Infrastructure\Persistence\Database;
use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use DI\ContainerBuilder;
use Illuminate\Contracts\Translation\Translator as TranslatorInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\RouteParserInterface;
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
        TranslatorInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');
            $loader = new FileLoader(new Filesystem(), $settings['translations_dir']);
            return new Translator($loader, $settings['default_locale']);
        },
    ]);

    $containerBuilder->addDefinitions([
        DatabaseInterface::class => function (ContainerInterface $c) {
            return new Database();
        },
    ]);
};
