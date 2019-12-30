<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use DI\NotFoundException;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

/**
 * Class ViewAction
 * @package App\Application\Actions\Entity
 */
class ViewAction extends UserAbstractAction
{
    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws HttpBadRequestException
     * @throws NotFoundException
     * @throws Exception
     */
    protected function action(ServerRequestInterface $request): Response
    {
        $id = (int) $this->resolveArg('id');
        $user = $this->userRepository->find($id);

        if (null == $user) {
            throw new NotFoundException("Entity not found.");
        }

        $this->logger->info("Entity of id `{$id}` was viewed.");

        return $this->twig->render($this->response, 'user/view.html.twig', [
            'user' => $user,
        ]);
    }
}
