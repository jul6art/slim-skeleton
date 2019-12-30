<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Services\Interfaces\AuthInterface;
use App\Application\Services\Traits\DumperTrait;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Illuminate\Contracts\Translation\Translator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Flash\Messages;
use Slim\Interfaces\RouteParserInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

/**
 * Class AbstractAction
 * @package App\Application\Actions
 */
abstract class AbstractAction
{
    use DumperTrait;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $args;

    /**
     * @var Twig
     */
    protected $twig;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var Messages
     */
    protected $flash;

    /**
     * @var AuthInterface
     */
    protected $auth;

    /**
     * @var RouteParserInterface
     */
    protected $router;

    /**
     * AbstractAction constructor.
     * @param LoggerInterface $logger
     * @param Twig $twig
     * @param Translator $translator
     * @param Messages $flash
     * @param AuthInterface $auth
     */
    public function __construct(LoggerInterface $logger, Twig $twig, Translator $translator, Messages $flash, AuthInterface $auth)
    {
        $this->logger = $logger;
        $this->twig = $twig;
        $this->translator = $translator;
        $this->flash = $flash;
        $this->auth = $auth;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        $this->router = RouteContext::fromRequest($request)->getRouteParser();

        try {
            return $this->action($request);
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(Request $request): Response;

    /**
     * @return array|object
     * @throws HttpBadRequestException
     */
    protected function getFormData()
    {
        $input = json_decode(file_get_contents('php://input'));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpBadRequestException($this->request, 'Malformed JSON input.');
        }

        return $input;
    }

    /**
     * @param  string $name
     * @return mixed
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name)
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * @param  array|object|null $data
     * @return Response
     */
    protected function respondWithData($data = null): Response
    {
        $payload = new ActionPayload(200, $data);
        return $this->respond($payload);
    }

    /**
     * @param ActionPayload $payload
     * @return Response
     */
    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);
        return $this->response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Response $response
     * @param string $route
     * @param array $parameters
     * @return Response
     */
    protected function redirectToRoute(Response $response, string $route, array $parameters = []): Response
    {
        return $response
            ->withHeader(
                'Location',
                $this->router->relativeUrlFor($route, array_replace($parameters, [
                    'locale'=> $this->twig->getEnvironment()->getGlobals()['app']['locale'],
                ]))
            )
            ->withStatus(302);
    }
}
