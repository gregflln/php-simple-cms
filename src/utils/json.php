<?php

namespace app\utils;

//use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

class json
{
    public static function response(array $data) : Response
    {
        $payload = json_encode($data);
        $response = new Response;
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}