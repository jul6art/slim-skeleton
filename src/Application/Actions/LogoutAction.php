<?php
declare(strict_types=1);

namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

/**
 * Class LogoutAction
 * @package App\Application\Actions
 */
class LogoutAction extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return $this->redirectToRoute(new Response(), 'app_homepage_i18n');
    }
}
