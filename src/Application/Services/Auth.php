<?php

namespace App\Application\Services;

use App\Application\Services\Interfaces\AuthInterface;
use App\Domain\Repository\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

/**
 * Class Auth
 * @package App\Application\Services
 */
class Auth implements AuthInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Auth constructor.
     * @param UserRepository $userRepository
     * @param LoggerInterface $logger
     */
    public function __construct(UserRepository $userRepository, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    /**
     * @return Model|null
     */
    public function user(): ?Model
    {
        if (!isset($_SESSION['user'])) {
            return null;
        }

        try {
            return $this->userRepository->find($_SESSION['user']);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());

            return null;
        }
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function attempt(string $email, string $password): bool
    {
        $user = $this->userRepository->findBy(['email' => $email])->first();

        if (null === $user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param Twig $twig
     * @return ResponseInterface
     */
    public function getRedirectUrl(Request $request, ResponseInterface $response, Twig $twig): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);

        return $response
            ->withHeader(
                'Location',
                $routeContext->getRouteParser()->relativeUrlFor('app_login', [
                    'locale'=> $twig->getEnvironment()->getGlobals()['app']['locale'],
                ])
            )
            ->withStatus(302);
    }
}