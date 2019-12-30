<?php
declare(strict_types=1);

namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

/**
 * Class LoginAction
 * @package App\Application\Actions
 */
class LoginAction extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $auth = $this->auth->attempt(
                filter_var($data['email'], FILTER_VALIDATE_EMAIL),
                filter_var($data['password'], FILTER_SANITIZE_STRING)
            );

            $response = new Response();

            if (!$auth) {
                $this->flash->addMessage('error', 'Could not sign you in with those details');
                return $this->redirectToRoute($response, 'app_login');
            }

            $this->flash->addMessage('success', 'Successful Login');
            return $this->redirectToRoute($response, 'app_homepage_i18n');
        }

        return $this->twig->render($this->response, 'security/login.html.twig');
    }
}
