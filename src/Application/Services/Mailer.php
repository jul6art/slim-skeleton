<?php

namespace App\Application\Services;

use App\Application\Services\Interfaces\MailerInterface;
use Swift_Attachment;
use Swift_Mailer;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Mailer
 * @package App\Application\Services
 */
class Mailer implements MailerInterface
{
    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var string
     */
    private $fromAddress;

    /**
     * @var string
     */
    private $fromName;

    /**
     * @var string[]
     */
    private $debugAddresses;

    /**
     * @var boolean
     */
    private $disableDelivery;

    /**
     * MailerService constructor.
     *
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     * @param string $fromAddress
     * @param string $fromName
     * @param array $debugAddresses
     * @param bool $disableDelivery
     */
    public function __construct(Swift_Mailer $mailer, Environment $twig, string $fromAddress, string $fromName, array $debugAddresses = [], bool $disableDelivery = false)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->fromAddress = $fromAddress;
        $this->fromName = $fromName;
        $this->debugAddresses = $debugAddresses;
        $this->disableDelivery = $disableDelivery;
    }

    /**
     * @param string     $to
     * @param string     $template
     * @param array      $context
     * @param array      $attachments
     * @param array|null $from
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Throwable
     */
    public function send(string $to, string $template, array $context = [], array $attachments = [], array $from = null): void
    {
        $message = new \Swift_Message();

        foreach ($attachments as $key => $value) {
            $files = $message->embed(Swift_Attachment::fromPath($value));
            $context['files'][] = $files;
        }

        $message
            ->setFrom($from ?? [
                    $this->fromAddress => $this->fromName,
                ])
            ->setTo($to)
            ->setSubject($this->twig->load($template)->renderBlock('subject', $context))
            ->setBody($this->twig->render($template, $context), 'text/html');

        if (array_key_exists('replyto', $context)) {
            $message->setReplyTo($context['replyto']);
        }

        if (array_key_exists('cc', $context)) {
            $message->setCc($context['cc']);
        }

        $bcc = $this->debugAddresses;
        if (array_key_exists('bcc', $context)) {
            $bcc = array_merge($bcc, $context['bcc']);
        }
        $message->setBcc($bcc);

        if (!$this->disableDelivery) {
            $this->mailer->send($message);
        }
    }
}
