<?php

namespace User\Repository;

use User\Repository\IUserRepository;
use User\User;

class UserRepositoryMock implements IUserRepository
{
    private $users = [];

    public function insertUser(User $user)
    {
        $user->id = count($this->users) + 1;
        $this->users[] = $user;
    }

    public function getUserByEmail(string $email)
    {
        foreach($this->users as $user) {
            if ($user->email == $email) return $user;
        }
        return null;
    }

    public function getUserByDocument(string $document)
    {
        foreach($this->users as $user) {
            if ($user->document == $document) return $user;
        }
        return null;
    }
}