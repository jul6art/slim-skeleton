<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Application\Services\Interfaces\AuthInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Flash\Messages;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

/**
 * Class AuthMiddleware
 * @package App\Application\Middleware
 */
class AuthMiddleware implements Middleware
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var AuthInterface
     */
    private $auth;

    /**
     * @var Messages
     */
    private $flash;

    /**
     * @var Twig
     */
    private $twig;

    /**
     * AuthMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->auth = $container->get(AuthInterface::class);
        $this->flash = $container->get(Messages::class);
        $this->twig = $container->get(Twig::class);
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);

        $response = $handler->handle($request);

        if (!$this->auth->check() and !\in_array($routeContext->getRoute()->getName(), [
            'app_login',
            'app_logout',
            'app_homepage',
            'app_homepage_i18n',
        ])) {
            $this->flash->addMessage('error', 'Please sign in before doing that');

            $response = new Response();
            return $this->auth->getRedirectUrl($request, $response, $this->twig);
        }

        return $response;
    }
}
