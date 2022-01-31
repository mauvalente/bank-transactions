<?php

namespace Transaction\Repository;

use Transaction\Balance;
use Transaction\Repository\IBalanceRepository;

class BalanceRepositoryMock implements IBalanceRepository
{
    private $balances = [];

    public function getBalanceByUserId(int $userId) : ?Balance
    {
        foreach($this->balances as $balance) {
            if ($balance->userId == $userId) return $balance;
        }

        return null;
    }

    public function save($balance) : void
    {
        for ($i=0; $i<=count($this->balances); $i++)
        {
            if ($this->balances[$i]->id == $balance->id)
            {
                $this->balances[$i] = $balance;
                break;
            }
        }
    }

    public function createBalanceForUserId($userId, $value) : Balance
    {
        $balance = new Balance();
        $balance->id = count($this->balances) + 1;
        $balance->userId = $userId;
        $balance->value = $value;

        $this->balances[] = $balance;

        return $balance;
    }
}