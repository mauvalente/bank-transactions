<?php

namespace User\Business;

use User\Repository\IUserRepository;

class GetUserByEmail
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function exec(string $email)
    {
        $user = $this->repository->getUserByEmail($email);

        return UserTypeFactory::factory($user);
    }
}