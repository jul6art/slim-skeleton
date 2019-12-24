<?php
declare(strict_types=1);

use App\Application\Actions\HomeAction;
use App\Application\Actions\User\ListAction;
use App\Application\Actions\User\ViewAction;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', HomeAction::class);

    $app->group('/users', function (Group $group) {
        $group->get('', ListAction::class);
        $group->get('/{id}', ViewAction::class);
    });

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: make sure this route is defined last
     */
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
