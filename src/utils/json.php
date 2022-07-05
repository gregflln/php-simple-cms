<?php

namespace app\utils;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

class json
{
    public static function request(Request $request) : array
    {
        return json_decode($request->getBody()->getContents(), true);
    }
    public static function response(array $data) : Response
    {
        $payload = json_encode($data);
        $response = new Response;
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}