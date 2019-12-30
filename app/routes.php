<?php
declare(strict_types=1);

use App\Application\Actions\HomeAction;
use App\Application\Actions\LoginAction;
use App\Application\Actions\LogoutAction;
use App\Application\Actions\User\ListAction;
use App\Application\Actions\User\ViewAction;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', HomeAction::class)->setName('app_homepage');
    $app->get('/{locale}/home', HomeAction::class)->setName('app_homepage_i18n');

    $app->get('/logout', LogoutAction::class)->setName('app_logout');

    $app->group('/{locale}/login', function (Group $group) {
        $group->get('', LoginAction::class)->setName('app_login');
        $group->post('', LoginAction::class)->setName('app_login');
    });

    $app->group('/{locale}/users', function (Group $group) {
        $group->get('', ListAction::class)->setName('app_user_list');
        $group->get('/{id}', ViewAction::class)->setName('app_user_view');
    });

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: make sure this route is defined last
     */
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
