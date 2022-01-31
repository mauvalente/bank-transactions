<?php

namespace User;

class Client extends User implements IUser 
{
    public function __construct($name, $document, $email, $password)
    {
        parent::__construct($name, $document, $email, $password);
    }

    function setUserType() : void
    {
        $this->type = User::CLIENT;
    }

    public static function clone($client)
    {
        $user = new self($client->name, $client->document, $client->email, $client->password);
        $user->id = $client->id;
        return $client;
    }
}