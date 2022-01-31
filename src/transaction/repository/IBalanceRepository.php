<?php

namespace Transaction\Repository;

use Transaction\Balance;

interface IBalanceRepository
{
    public function getBalanceByUserId(int $userId) : ?Balance;

    public function save($balance) : void;

    public function createBalanceForUserId($userId, $value) : Balance;
}