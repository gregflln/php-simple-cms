<?php

namespace app\entities;

class user
{
    private int $id;
    private string $name;
    private string $lastname;
    private string $email;
    private string $password;
    private string $access_token;

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