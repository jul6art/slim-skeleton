<?php

namespace App\Application\Middleware;

use App\Application\Twig\Extension\AssetExtension;
use App\Application\Twig\Extension\DumpExtension;
use App\Application\Twig\Extension\TranslatorExtension;
use Fullpipe\TwigWebpackExtension\WebpackExtension;
use Illuminate\Contracts\Translation\Translator;
use Psr\Container\ContainerInterface;
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
        $this->twig->addExtension(new TranslatorExtension($this->container->get(Translator::class)));
        $this->twig->addExtension(new DumpExtension());
        $this->twig->addExtension(new AssetExtension($this->container));
        $this->twig->addExtension(new WebpackExtension(
            __DIR__ . '/../../../public/assets/manifest.json',
            'assets/',
            'assets/'
        ));

        return $handler->handle($request);
    }
}