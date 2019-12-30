<?php

namespace App\Application\Twig\Extension;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Routing\RouteContext;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class PathExtension
 * @package App\Application\Twig\Extension
 */
class PathExtension extends AbstractExtension
{
    /**
     * @var RouteParserInterface
     */
    private $router;

    /**
     * PathExtension constructor.
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->router = RouteContext::fromRequest($request)->getRouteParser();
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('asset', [$this, 'asset']),
            new TwigFunction('fullUrl', [$this, 'fullUrlFor']),
            new TwigFunction('relativeUrl', [$this, 'relativeUrlFor']),
            new TwigFunction('url', [$this, 'urlFor']),
        ];
    }

    /**
     * @param string $path
     * @return string
     */
    public function asset(string $path) : string
    {
        return sprintf(
            '%s%s%s%s',
            DIRECTORY_SEPARATOR,
            'assets',
            DIRECTORY_SEPARATOR,
            $path
        );
    }

    /**
     * @param string $routeName
     * @param array $data
     * @param array $queryParams
     * @return string
     */
    public function fullUrlFor(string $routeName, array $data = [], array $queryParams = []): string
    {
        return $this->router->fullUrlFor($routeName, $data, $queryParams);
    }

    /**
     * @param string $routeName
     * @param array $data
     * @param array $queryParams
     * @return string
     */
    public function relativeUrlFor(string $routeName, array $data = [], array $queryParams = []): string
    {
        return $this->router->relativeUrlFor($routeName, $data, $queryParams);
    }

    /**
     * @param string $routeName
     * @param array $data
     * @param array $queryParams
     * @return string
     */
    public function urlFor(string $routeName, array $data = [], array $queryParams = []): string
    {
        return $this->router->urlFor($routeName, $data, $queryParams);
    }
}