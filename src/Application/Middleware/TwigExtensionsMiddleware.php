<?php

namespace App\Application\Middleware;

use App\Application\Twig\Extension\PathExtension;
use App\Application\Twig\Extension\DumpExtension;
use App\Application\Twig\Extension\TranslatorExtension;
use Fullpipe\TwigWebpackExtension\WebpackExtension;
use Illuminate\Contracts\Translation\Translator;
use Knlv\Slim\Views\TwigMessages;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Class TwigExtensionsMiddleware
 * @package App\Application\Middleware
 */
class TwigExtensionsMiddleware implements Middleware
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * TwigExtensionsMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get(Twig::class);
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        // @TODO make usage of tokenStorageInterface
        $twigApp = $this->twig->getEnvironment()->getGlobals()['app'] ?? [];
        $this->twig->getEnvironment()->addGlobal('app', array_replace($twigApp, ['user' => 'toto']));

        $this->twig->addExtension(new TwigMessages(new Messages()));
        $this->twig->addExtension(new TranslatorExtension($this->container->get(Translator::class)));
        $this->twig->addExtension(new DumpExtension());
        $this->twig->addExtension(new PathExtension($request));
        $this->twig->addExtension(new WebpackExtension(
            __DIR__ . '/../../../public/assets/manifest.json',
            'assets/',
            'assets/'
        ));

        return $handler->handle($request);
    }
}