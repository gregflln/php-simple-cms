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
    //subsribe endpoint
    public function subscribe(Request $request, Response $response, $args)
    {
        $req = json::request($request);
        $this->user->create([
            "name" => $req->name,
            "lastname" => $req->lastname,
            "email" => $req->email,
            "password" => $req->password
        ]);
        return json::response([
            "ack" => true
        ]);
    }
    //login
    public function login(Request $request, Response $response, $args)
    {
        $req = json::request($request);

        $email = $req->email;
        $password = $req->password;
        $auth = $this->user->login($email, $password);

        if ($auth)
        {
            return json::response([
                "access_token" => $auth
            ]);
        } else {
            return json::response([
                "ack" => false
            ]);
        }
    }
    //user endpoint
    public function user(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $user = $this->user->get($id);
        return json::response([
            "id" => $user->id,
            "name" => $user->name,
            "lastname" => $user->lastname,
            "email" => $user->email,
            "status" => $user->status
        ]);
    }
    //authorize endpoint
    public function authorize(Request $request, Response $response, $args)
    {
        $id = $args["id"];
        $user = $this->user->authorize($id);

        return json::response([
            "ack" => true
        ]);

    }
    //get All
    public function getAll(Request $request, Response $response, $args)
    {
        $users = $this->user->getAll();

        return json::response($users);
    }
    public function revoke(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $this->user->revoke($id);

        return json::response([
            "ack" => true
        ]);
    }
    public function setAdmin(Request $request, Response $response, $args)
    {

    }
}