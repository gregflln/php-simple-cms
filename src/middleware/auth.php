<?php

namespace app\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use R;

require_once '../manager/rb.php';

class auth
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $auth_header = $request->getHeader("Authorization");
        $access_token = ltrim($auth_header, 7);
        
        return $response;
    }
}