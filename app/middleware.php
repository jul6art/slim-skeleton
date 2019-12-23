<?php
declare(strict_types=1);

use App\Application\Middleware\CLIMiddleware;
use App\Application\Middleware\SessionMiddleware;
use App\Application\Middleware\TwigExtensionsMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->add(TwigExtensionsMiddleware::class);
    $app->add(CLIMiddleware::class);
};
