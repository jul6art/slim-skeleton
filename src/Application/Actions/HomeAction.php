<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Actions\AbstractAction;
use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

/**
 * Class HomeAction
 * @package App\Application\Actions
 */
class HomeAction extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(ServerRequestInterface $request): Response
    {
        return $this->twig->render($this->response, 'default/index.html.twig', [
            'foo' => 'bar'
        ]);
    }
}
