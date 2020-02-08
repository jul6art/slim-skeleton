<?php

namespace App\Application\Twig\Extension;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Uri;
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
     * @var RouteInterface|null
     */
    private $route;

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
        $this->route = RouteContext::fromRequest($request)->getRoute();
        $this->router = RouteContext::fromRequest($request)->getRouteParser();
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('asset', [$this, 'asset']),
            new TwigFunction('currentRoute', [$this, 'getCurrentRoute']),
            new TwigFunction('currentRouteName', [$this, 'getCurrentRouteName']),
            new TwigFunction('fullUrl', [$this, 'fullUrlFor']),
            new TwigFunction('isCurrent', [$this, 'isCurrentRoute']),
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
     * @return RouteInterface|null
     */
    public function getCurrentRoute(): ?RouteInterface
    {
        return $this->route;
    }

    /**
     * @return string|null
     */
    public function getCurrentRouteName(): ?string
    {
        return $this->route ? $this->route->getName() : null;
    }

    /**
     * @param string $routeName
     * @param array $data
     * @param array $queryParams
     * @return string
     */
    public function fullUrlFor(string $routeName, array $data = [], array $queryParams = []): string
    {
        /**
         * @TODO Build Uri with scheme, host, ...
         */
        //return $this->router->fullUrlFor(new Uri(), $routeName, $data, $queryParams);

        return '';
    }

    /**
     * @param string $routeName
     * @return bool
     */
    public function isCurrentRoute(string $routeName): bool
    {
        return $routeName === ($this->route ? $this->route->getName() : null);
    }

    /**
     * @deprecated use urlFor method instead
     *
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
