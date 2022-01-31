<?php

namespace User\Repository;

use User\Repository\IUserRepository;

class CheckUniqueEmail
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function exec($email)
    {
        return is_null(
            $this->repository->getUserByEmail($email)
        );
    }
}