<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

/**
 * Class ListAction
 * @package App\Application\Actions\Entity
 */
class ListAction extends UserAbstractAction
{
    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    protected function action(Request $request): Response
    {
        $this->logger->info("Users list was viewed.");

        $route = RouteContext::fromRequest($request)->getRoute();
        $router = RouteContext::fromRequest($request)->getRouteParser();

        /**
         * @TODO IF YOU DON'T WANT INSTANT FLASH OR BEFORE REDIRECT, USE
         *
         * $this->flash->addMessage() instead
         */
        $this->addFlash('success', "Success flash message");

        // $this->dump($this->translator->get('messages.greet', ['name' => 'Johnnyhood'], 'fr'));
        // $this->dd($this->translator->get('messages.greet', ['name' => 'Johnnyhood']));

        return $this->render($this->response, 'user/list.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }
}
