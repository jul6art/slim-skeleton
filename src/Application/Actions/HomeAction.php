<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

/**
 * Class HomeAction
 * @package App\Application\Actions
 */
class HomeAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->twig->render($this->response, 'default/index.html.twig', [
            'foo' => 'bar'
        ]);
    }
}
