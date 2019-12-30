<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\AbstractAction;
use App\Domain\Repository\UserRepository;
use Illuminate\Contracts\Translation\Translator;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
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
     * @param Translator $translator
     * @param Messages $flash
     * @param UserRepository $userRepository
     */
    public function __construct(LoggerInterface $logger, Twig $twig, Translator $translator, Messages $flash, UserRepository $userRepository)
    {
        parent::__construct($logger, $twig, $translator, $flash);
        $this->userRepository = $userRepository;
    }
}
