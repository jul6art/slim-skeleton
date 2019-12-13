<?php
declare(strict_types=1);

namespace App\Application\Actions\Test;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class TestAction extends Action
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @param LoggerInterface $logger
     * @param UserRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, Twig $twig)
    {
        parent::__construct($logger);
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->twig->render($this->response, 'test.html.twig', [
            'foo' => 'bar'
        ]);
    }
}
