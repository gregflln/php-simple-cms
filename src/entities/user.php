<?php

namespace app\entities;

use app\entities\role;

class user
{
    public int $id;
    public string $name;
    public string $lastname;
    public string $access_token;
    public string $password;
    public role $role;
}