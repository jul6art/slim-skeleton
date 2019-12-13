<?php
declare(strict_types=1);

use App\Application\Actions\Test\TestAction;
use Slim\App;

return function (App $app) {
    $app->get('/{name}', TestAction::class);

//    $app->group('/users', function (Group $group) {
//        $group->get('', ListUsersAction::class);
//        $group->get('/{id}', ViewUserAction::class);
//    });
};
