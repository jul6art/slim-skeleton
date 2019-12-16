<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Post\PostRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

/**
 * Class ListUsersAction
 * @package App\Application\Actions\User
 */
class ListUsersAction extends UserAction
{

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * ListUsersAction constructor.
     * @param LoggerInterface $logger
     * @param Twig $twig
     * @param UserRepository $userRepository
     * @param PostRepository $postRepository
     */
    public function __construct(LoggerInterface $logger, Twig $twig, UserRepository $userRepository, PostRepository $postRepository)
    {
        parent::__construct($logger, $twig, $userRepository);
        $this->postRepository = $postRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->userRepository->findAll();

        $this->dump($this->postRepository->findAll());

        $this->logger->info("Users list was viewed.");

        return $this->twig->render($this->response, 'user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
