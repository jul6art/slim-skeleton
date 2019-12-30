<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\AbstractAction;
use App\Application\Services\Interfaces\AuthInterface;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Repository\UserRepository;
use Illuminate\Contracts\Translation\Translator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Flash\Messages;
use Slim\Views\Twig;

/**
 * Class UserAbstractAction
 * @package App\Application\Actions\Entity
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
     * @param AuthInterface $auth
     * @param UserRepository $userRepository
     */
    public function __construct(LoggerInterface $logger, Twig $twig, Translator $translator, Messages $flash, AuthInterface $auth, UserRepository $userRepository)
    {
        parent::__construct($logger, $twig, $translator, $flash, $auth);
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws HttpBadRequestException
     * @throws HttpNotFoundException
     */
    public function __invoke(Request $request, ResponseInterface $response, $args): ResponseInterface
    {
        if (!$this->auth->check()) {
            return $this->auth->getRedirectUrl($request, $response, $this->twig);
        }

        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action($request);
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }
}
