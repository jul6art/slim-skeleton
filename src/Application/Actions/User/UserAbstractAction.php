<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\AbstractAction;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

/**
 * Class UserAbstractAction
 * @package App\Application\Actions\User
 */
abstract class UserAbstractAction extends AbstractAction
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserAbstractAction constructor.
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
