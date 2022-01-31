<?php

namespace User\Repository;

use User\User;

class SaveUser
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function exec(User $user)
    {
        $this->repository->insertUser($user);
    }
}