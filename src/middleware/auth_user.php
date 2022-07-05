<?php

namespace app\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use R;

require_once __DIR__ . '/../rb.php';

class auth_user
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $auth_header = $request->getHeader("Authorization");
        $access_token = ltrim($auth_header, 7);

        R::setup('mysql:host=localhost;dbname=pleyades','root','');

        $user = R::findOne('users', 'access_token = ?', [$access_token]);
        //check user exist
        if ($user->id === 0) return $response->withStatus(401);
        //status check
        if ($user->status === 'user' || 'admin') return $response;

        return $response;

    }
}