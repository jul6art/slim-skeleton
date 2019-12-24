<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class ListAction
 * @package App\Application\Actions\User
 */
class ListAction extends UserAbstractAction
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    protected function action(): Response
    {
        $this->logger->info("Users list was viewed.");

        return $this->twig->render($this->response, 'user/list.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }
}
