<?php

namespace app\entities;

class user
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $lastname = null;
    public ?string $access_token = null;
    public ?string $password = null;
    public ?string $status = null;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value)
        {
            $this->$key = $value;
        }
    }
}