<?php

namespace app\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use app\manager\userManager;
use app\utils\json;
use DI\Container;

class user
{
    private Container $container;
    private userManager $user;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->user = new userManager();
    }
    public function subscribe(Request $request, Response $response, $args)
    {
        $req = json_decode($request->getBody()->getContents());
        $this->user->create([
            "name" => $req->name,
            "lastname" => $req->lastname,
            "email" => $req->email,
            "password" => $req->password
        ]);
    }
    public function login(Request $request, Response $response, $args)
    {
        $req = json_decode($request->getBody()->getContents());

        $email = $req->email;
        $password = $req->password;
        
        return json::response($response, [
            "email" => $email,
            "password" => $password
        ]);
    }
    public function auth(Request $request, Response $response, $args)
    {
        return $response;
    }
    public function revoke(Request $request, Response $response, $args)
    {

    }
    public function setAdmin(Request $request, Response $response, $args)
    {

    }
}