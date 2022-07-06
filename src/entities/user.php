<?php

namespace app\entities;

class user
{
    public int $id;
    public string $name;
    public string $lastname;
    public string $email;
    public string $password;
    public string $access_token;

    public function __construct(int $id, string $name, string $lastname, string $email, string $password, string $access_token)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->access_token = $access_token;

    }
    
}