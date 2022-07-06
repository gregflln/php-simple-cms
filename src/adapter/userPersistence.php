<?php

namespace app\adapter;

use app\entities\user;
use R;

require_once __DIR__ . "../rb.php";

class userAdapter
{
    public function __construct()
    {
        R::setup('mysql:host=localhost;dbname=pleyades','root','');
    }
    public function create(user $user) : void
    {
        $newuser = R::dispense('users');

        $newuser->status = 'pending';
        $newuser->name = $user["name"];
        $newuser->lastname = $user["lastname"];
        $newuser->email = $user["email"];
        $newuser->password = hash('sha256', $user["password"]);

        R::store($newuser);
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
            "status" => $user_data['status'],
            "password" => $user_data["password"]
        ]);

        return $user;
    }
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
    public function changeStatus(user $user, string $status) : void
    {

    }
}