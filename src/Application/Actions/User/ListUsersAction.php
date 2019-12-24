<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Interfaces\DatabaseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

/**
 * Class ListUsersAction
 * @package App\Application\Actions\User
 */
class ListUsersAction extends UserAbstractAction
{
    /**
     * @var DatabaseInterface
     */
    private $database;

    /**
     * ListUsersAction constructor.
     * @param LoggerInterface $logger
     * @param Twig $twig
     * @param UserRepository $userRepository
     * @param DatabaseInterface $database
     */
    public function __construct(LoggerInterface $logger, Twig $twig, UserRepository $userRepository, DatabaseInterface $database)
    {
        parent::__construct($logger, $twig, $userRepository);
        $this->database = $database;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->userRepository->findAll();

        //$this->dd($this->database->getCapsule());

        //$this->dump($this->postRepository->findAll());

        $this->logger->info("Users list was viewed.");

        return $this->twig->render($this->response, 'user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
