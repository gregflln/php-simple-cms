<?php

namespace app\entities;

enum role
{
    case admin;
    case pending;
    case user;
    case revoked;
}