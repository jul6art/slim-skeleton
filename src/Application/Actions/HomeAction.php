<?php
declare(strict_types=1);

namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class HomeAction
 * @package App\Application\Actions
 */
class HomeAction extends AbstractAction
{
    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function action(ServerRequestInterface $request): Response
    {
        return $this->render($this->response, 'default/index.html.twig', [
            'foo' => 'bar'
        ]);
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, ResponseInterface $response, $args): ResponseInterface
    {
        if (!$this->auth->check()) {
            return $this->auth->getRedirectUrl($request, $response, $this->twig);
        }

        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        return $this->action($request);
    }
}
