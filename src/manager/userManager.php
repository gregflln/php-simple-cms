<?php

namespace app\manager;

use app\entities\user;
use app\entities\role;
use R;

require_once 'rb.php';
//user uses cases
//this user top level API

class userManager
{
    private R $r;

    public function __construct()
    {
        R::setup('mysql:host=localhost;dbname=pleyades','root','');
    }
    public function create(array $user) : void
    {
        $newuser = R::dispense('users');

        $newuser->role = 'pending';
        $newuser->name = $user["name"];
        $newuser->lastname = $user["lastname"];
        $newuser->email = $user["email"];
        $newuser->password = hash('sha256', $user["password"]);

        R::store($newuser);
    }
    public function authorize(int $id) : void
    {
        $user = R::load('users', $id);
        $user->access_token = \bin2hex(openssl_random_pseudo_bytes(32));
        $user->role = "user";
        R::store($user);
    }
    public function login(string $email, string $password) : string | bool
    {
        $hash_password = hash('sha256', $password);
        $user = R::findOne('users', "email = ?", [ $email ]);

        if ($hash_password === $user['password'])
        return $user["access_token"];
        else
        return false;
    }
    public function getAll() : array
    {
        $users = R::findAll('users');
        return $users;
    }
    public function get(int $id) : user
    {
        $user_data = R::load('users', $id);

        $user = new user([
            "id" => $user_data->id,
            "name" => $user_data["name"],
            "access_token" => $user_data['access_token'],
            "lastname" => $user_data["lastname"],
            "email" => $user_data["email"],
            "role" => $user_data['role'],
            "password" => $user_data["password"]
        ]);

        return $user;
    }
    public function revoke(int $id) : void
    {
        $user = R::load('users', $id);
        $user->role = "revoked";
        R::store($user);
    }
}