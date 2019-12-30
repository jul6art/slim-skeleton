<?php

namespace App\Application\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;

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
}
