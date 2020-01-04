<?php
declare(strict_types=1);

use App\Application\Services\Auth;
use App\Application\Services\Interfaces\AuthInterface;
use App\Application\Services\Interfaces\MailerInterface;
use App\Application\Services\Mailer;
use App\Domain\Repository\UserRepository;
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
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

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
        Messages::class => function (ContainerInterface $c) {
            return new Messages();
        },
    ]);

    $containerBuilder->addDefinitions([
        AuthInterface::class => function (ContainerInterface $c) {
            return new Auth($c->get(UserRepository::class), $c->get(LoggerInterface::class));
        },
    ]);

    $containerBuilder->addDefinitions([
        Twig::class => function (ContainerInterface $c) {
            $loader = new FilesystemLoader($c->get('settings')['templates_dir']);
            return new Twig($loader, ['cache' => false]);
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

    $containerBuilder->addDefinitions([
        MailerInterface::class => function (ContainerInterface $c) {
            $emailSettings = $c->get('settings')['email'];
            return new Mailer(
                new Swift_Mailer(new Swift_SmtpTransport($emailSettings['host'], $emailSettings['port'])),
                $c->get(Twig::class)->getEnvironment(),
                $emailSettings['from']['address'],
                $emailSettings['from']['name'],
                $emailSettings['debug'],
                $emailSettings['disable_delivery'] == 'true'
            );
        },
    ]);
};
