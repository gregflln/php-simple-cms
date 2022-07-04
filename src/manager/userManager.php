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

        $newuser->role = role::pending;
        $newuser->name = $user->name;
        $newuser->email = $user->email;
        $newuser->lastname = $user->lastname;
        $newuser->password = hash('sha256', $user->password);

        R::store($newuser);
    }
    public function authorize(int $id) : void
    {
        $user = R::dispense('users', $id);
        $user->access_token = \bin2hex(random_bytes(32));
        R::store($user);
    }
    public function getAll() : array
    {
        $users = R::dispenseAll('users');
        return $users;
    }
    public function get(int $id) : User
    {
        $user = R::dispense('users', $id);
        return $user;
    }
    public function revoke(int $id) : void
    {
        $user = R::dispense('users', $id);
        $user->role = role::revoke;
    }
}