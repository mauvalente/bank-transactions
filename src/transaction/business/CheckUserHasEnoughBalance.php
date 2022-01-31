<?php

namespace Transaction\Business;

use Transaction\Repository\IBalanceRepository;


class CheckUserHasEnoughBalance
{
    private $repository;

    public function __construct(IBalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function exec($user, $amount)
    {
        $balance = $this->repository->getBalanceByUserId($user->id);

        return ($amount <= $balance->value);
    }
}