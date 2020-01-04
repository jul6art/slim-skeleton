<?php
declare(strict_types=1);

namespace App\Application\Actions\Test;

use App\Application\Actions\AbstractAction;
use App\Application\Services\Interfaces\AuthInterface;
use App\Application\Services\Interfaces\MailerInterface;
use Illuminate\Contracts\Translation\Translator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;

/**
 * Class EmailAction
 * @package App\Application\Actions
 */
class EmailAction extends AbstractAction
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * EmailAction constructor.
     * @param LoggerInterface $logger
     * @param Twig $twig
     * @param Translator $translator
     * @param Messages $flash
     * @param AuthInterface $auth
     * @param MailerInterface $mailer
     */
    public function __construct(LoggerInterface $logger, Twig $twig, Translator $translator, Messages $flash, AuthInterface $auth, MailerInterface $mailer)
    {
        parent::__construct($logger, $twig, $translator, $flash, $auth);
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(ServerRequestInterface $request): Response
    {
        $this->mailer->send('admin@vsweb.be', 'email/test.html.twig');

        return $this->redirectToRoute(new \Slim\Psr7\Response(), 'app_homepage');
    }
}
