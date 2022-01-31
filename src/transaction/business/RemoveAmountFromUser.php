<?php

namespace Transaction\Business;

use User\IUser;
use Transaction\Balance;
use Transaction\Repository\IBalanceRepository;

class RemoveAmountFromUser
{
    private $balanceRepository;

    public function __construct(IBalanceRepository $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function exec(IUser $user, float $value)
    {
        $balance = $this->balanceRepository->getBalanceByUserId($user->id);

        if (is_null($balance)) 
        {
            $this->balanceRepository->createBalanceForUserId($user->id, $value);
        } 
        else 
        {
            $balance->value -= $value;
            $this->saveUpdatedBalance($balance);
        }
    }

    private function saveUpdatedBalance(Balance $balance)
    {
        try 
        {
            $this->balanceRepository->save($balance);
        }
        catch (\Exception $e) 
        {
            throw new \Exception\AmountNotRemovedException($e->getMessage());
        }
    }
}