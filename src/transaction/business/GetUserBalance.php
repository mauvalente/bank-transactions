<?php

namespace Transaction\Business;

use Transaction\Repository\IBalanceRepository;

class GetUserBalance
{
    private $balanceRepository;


    public function __construct(IBalanceRepository $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function exec($userId)
    {
        return $this->balanceRepository->getBalanceByUserId($userId);
    }
}