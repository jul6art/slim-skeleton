<?php

namespace App\Application\Middleware;

use App\Application\Twig\Extension\AssetExtension;
use App\Application\Twig\Extension\DumpExtension;
use Fullpipe\TwigWebpackExtension\WebpackExtension;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Class TwigExtensionsMiddleware
 * @package App\Application\Middleware
 */
class TwigExtensionsMiddleware implements Middleware {
    /**
     * @var Twig
     */
    private $twig;

    /**
     * TwigExtensionsMiddleware constructor.
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig   = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $this->twig->addExtension(new DumpExtension());
        $this->twig->addExtension(new AssetExtension());
        $this->twig->addExtension(new WebpackExtension(
            __DIR__ . '/../../../public/assets/manifest.json',
            'assets/',
            'assets/'
        ));

        return $handler->handle($request);
    }
}