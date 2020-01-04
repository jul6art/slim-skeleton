<?php

namespace App\Application\Services\Interfaces;

/**
 * Interface MailerInterface
 * @package App\Application\Services\Interfaces
 */
interface MailerInterface
{
    /**
     * @param string     $to
     * @param string     $template
     * @param array      $context
     * @param array      $attachments
     * @param array|null $from
     */
    public function send(string $to, string $template, array $context = [], array $attachments = [], array $from = null): void;
}
