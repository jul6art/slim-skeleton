<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

abstract class UserAction extends Action
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserAction constructor.
     * @param LoggerInterface $logger
     * @param Twig $twig
     * @param UserRepository $userRepository
     */
    public function __construct(LoggerInterface $logger, Twig $twig, UserRepository $userRepository)
    {
        parent::__construct($logger, $twig);
        $this->userRepository = $userRepository;
    }
}
