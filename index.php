<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;
use app\controllers;
use DI\Container;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

//all
$app->post('/login', [controllers\user::class, 'login']);
$app->post('/subscribe', [controllers\user::class, 'subscribe']);

$app->group('/api', function (RouteCollectorProxy $group) {

    //users
    $group->get('/users', [controllers\user::class, 'getAll']);
    $group->post('/user/{id}', [controllers\user::class, 'user']);

    //admin
    $group->post('/authorize/{id}', [controllers\user::class, 'authorize']);
    $group->post('/setadmin/{id}', [controllers\user::class, 'setAdmin']);
    $group->post('/revoke/{id}', [controllers\user::class, 'revoke']);

});

$app->run();