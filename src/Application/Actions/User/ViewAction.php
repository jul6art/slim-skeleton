<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use DI\NotFoundException;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

/**
 * Class ViewAction
 * @package App\Application\Actions\User
 */
class ViewAction extends UserAbstractAction
{
    /**
     * @return Response
     * @throws NotFoundException
     * @throws HttpBadRequestException
     * @throws Exception
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $user = $this->userRepository->find($id);

        if (null == $user) {
            throw new NotFoundException("User not found.");
        }

        $this->logger->info("User of id `{$id}` was viewed.");

        return $this->twig->render($this->response, 'user/view.html.twig', [
            'user' => $user,
        ]);
    }
}
