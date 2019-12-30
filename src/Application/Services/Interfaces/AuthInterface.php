<?php

namespace App\Application\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

/**
 * Interface AuthInterface
 * @package App\Application\Services\Interfaces
 */
interface AuthInterface
{
    /**
     * @return Model|null
     */
    public function user(): ?Model;

    /**
     * @return bool
     */
    public function check(): bool;

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function attempt(string $email, string $password): bool;

    public function logout(): void;

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param Twig $twig
     * @return ResponseInterface
     */
    public function getRedirectUrl(Request $request, ResponseInterface $response, Twig $twig): ResponseInterface;
}
