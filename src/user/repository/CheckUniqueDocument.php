<?php

namespace User\Repository;

use User\Repository\IUserRepository;

class CheckUniqueDocument
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function exec($document)
    {
        return is_null(
            $this->repository->getUserByDocument($document)
        );
    }
}