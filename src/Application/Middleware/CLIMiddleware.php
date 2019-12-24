<?php

namespace App\Application\Middleware;

use App\Application\Command\Traits\CommandLineTrait;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;
use Slim\Psr7\Response;

/**
 * Class CLIMiddleware
 * @package App\Application\Middleware
 */
class CLIMiddleware implements Middleware
{
    use CommandLineTrait;

    /*
     * @var ContainerInterface
     */
    protected $container;

    /**
     * CLIMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (\PHP_SAPI !== 'cli') {
            return $handler->handle($request);
        }

        $response = new Response();

        global $argv;

        if (count($argv) > 1) {
            $command = $argv[1];
            $args = array_slice($argv, 2);
        } else {
            $command = '__default';
            $args = [];
        }

        $commands = $this->container->get('commands');

        try {
            if (array_key_exists($command, $commands)) {
                $class = $commands[$command];

                if (!class_exists($class)) {
                    throw new RuntimeException(sprintf('Class %s does not exist', $class));
                }

                $commandClass = new ReflectionClass($class);

                if (!$commandClass->hasMethod('command')) {
                    throw new RuntimeException(sprintf('Class %s does not have a command() method', $class));
                }

                if ($commandClass->getConstructor()) {
                    $task_construct_method = new ReflectionMethod($class,  '__construct');
                    $construct_params = $task_construct_method->getParameters();

                    if (count($construct_params) == 0) {
                        // Create a new instance without any args
                        $task = $commandClass->newInstanceArgs();
                    } elseif (count($construct_params) == 1) {
                        // Create a new instance and pass the container by reference, if needed
                        if ($construct_params[0]->isPassedByReference()) {
                            $task = $commandClass->newInstanceArgs([&$this->container]);
                        } else {
                            $task = $commandClass->newInstanceArgs([$this->container]);
                        }
                    } else {
                        throw new RuntimeException(sprintf('Class %s has an unsupported __construct method', $class));
                    }
                } else {
                    $task = $commandClass->newInstanceWithoutConstructor();
                }

                $task->command($args);
            } else {
                $this->error('Command not found');
            }

            $response->getBody()->write('');

            return $response;
        } catch(Exception $e) {
            throw $e;
        }
    }
}