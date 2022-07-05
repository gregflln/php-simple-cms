<?php

//use Psr\Http\Message\ResponseInterface as Response;
//use Psr\Http\Message\ServerRequestInterface as Request;
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

//user auth
$app->group('/api', function (RouteCollectorProxy $group) {

    //users
    $group->get('/users', [controllers\user::class, 'get_users']);
    $group->get('/user/{id}', [controllers\user::class, 'get_user']);

    //admin
    $group->post('/set_as_user/{id}', [controllers\user::class, 'set_as_user']);
    $group->post('/set_as_admin/{id}', [controllers\user::class, 'set_as_admin']);
    $group->post('/revoke/{id}', [controllers\user::class, 'revoke']);

});

$app->run();