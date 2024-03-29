<?php

namespace app\manager;

use app\entities\user;
use R;

require_once __DIR__ . '/../rb.php';
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

        $newuser->status = 'pending';
        $newuser->name = $user["name"];
        $newuser->lastname = $user["lastname"];
        $newuser->email = $user["email"];
        $newuser->password = hash('sha256', $user["password"]);

        R::store($newuser);
    }
    //regenerate new token and invdalidate previously issued tokens
    public function generate_token(int $id)
    {
        $user = R::load('users', $id);
        $user->access_token = bin2hex(openssl_random_pseudo_bytes(32));
        R::store($user);
    }
    //check credentials and give access_token
    public function login(string $email, string $password) : string | bool
    {
        $hash_password = hash('sha256', $password);
        $user = R::findOne('users', "email = ?", [ $email ]);

        //password match && access_token exist
        if (
            $hash_password === $user->password &&
            $user->access_token !== null &&
            $user->status !== 'pending' &&
            $user->status !== 'revoked'
            )
            return $user->access_token;
        else
            return false;
    }
    //retrieve all users
    public function getAll() : array
    {
        $users = R::findAll('users');
        
        foreach ($users as $index => $user) {
            foreach($user as $key => $value)
            {
                if ($key == "access_token" || $key === "password")
                {
                    //remove access-token && password fields from DB response
                    unset($users[$index][$key]);
                }
            }
        }
        return $users;
    }
    //get user data, sensitive data include
    public function get(int $id) : user
    {
        $user_data = R::load('users', $id);

        $user = new user([
            "id" => $user_data->id,
            "name" => $user_data["name"],
            "access_token" => $user_data['access_token'],
            "lastname" => $user_data["lastname"],
            "email" => $user_data["email"],
            "status" => $user_data['status'],
            "password" => $user_data["password"]
        ]);

        return $user;
    }
    //change status of user [ id ] to status
    public function changeSatus(int $id, string $to_status) : void
    {
        $user = R::load('users', $id);
        $user->status = $to_status;
        R::store($user);
    }
}