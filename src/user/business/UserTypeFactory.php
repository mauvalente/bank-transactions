<?php

namespace User\Business;

use User\IUser;
use User\User;
use User\Client;
use User\Logist;

class UserTypeFactory
{
    static function factory(IUser $user)
    {
        switch($user->type) {
            case User::CLIENT:
                return Client::clone($user);
                break;
            case User::LOGIST:
                return Logist::clone($user);
        }
    }
}