<?php

namespace User;

class Logist extends User implements IUser
{
    public function __construct($name, $document, $email, $password)
    {
        parent::__construct($name, $document, $email, $password);
    }

    function setUserType() : void
    {
        $this->type = User::LOGIST;
    }

    public static function clone($logist)
    {
        return new self($logist->id, $logist->name, $logist->document, $logist->email, $logist->password);
    }
}