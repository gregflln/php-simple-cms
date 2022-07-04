<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use app\controllers;
use DI\Container;

require __DIR__ . '/vendor/autoload.php';

//$app = AppFactory::create();
$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();


$app->post('/login', [controllers\user::class, 'login']);
$app->post('/subscribe', [controllers\user::class, 'subscribe']);

$app->run();