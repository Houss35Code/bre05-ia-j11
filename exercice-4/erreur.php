<?php

class User
{
    public function __construct(private string $username)
    {

    }
}

$user = new User("Gaston");
echo $user->username;