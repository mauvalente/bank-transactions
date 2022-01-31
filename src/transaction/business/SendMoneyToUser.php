<?php

namespace Transaction\Business;

use User\User;
use User\IUser;
use Transaction\Repository\IBalanceRepository;
use Transaction\Repository\IAuthenticatedService;

class SendMoneyToUser
{
    private $repository;
    private $authenticatedService;

    public function __construct(IBalanceRepository $repository, IAuthenticatedService $authenticatedService)
    {
        $this->repository = $repository;
        $this->authenticatedService = $authenticatedService;
    }

    public function exec(IUser $payer, IUser $payee, float $amount) {
        if ($payer->type != User::CLIENT) {
            throw new \Exception\LogistSendMoneyException("Payer cannot be a Logist");
        }

        $checkBalanceUser = new CheckUserHasEnoughBalance($this->repository);
        
        if (! $checkBalanceUser->exec($payer, $amount) ) 
        {
            throw new \Exception\UserHasNotEnoughBalanceException("Payer has not enough Balance");
        }

        try 
        {
            $addAmountToUser = new AddAmountToUser($this->repository);
            $addAmountToUser->exec($payee, $amount);

            $removeAmountFromUser = new RemoveAmountFromUser($this->repository);
            $removeAmountFromUser->exec($payer, $amount);

            $chechAuthenticatedService = new CheckAuthenticatedService($this->authenticatedService);
            $check = $chechAuthenticatedService->exec();
            
            if (!$check) {
                throw new \Exception\TransactionNotAuthenticatedException("Revert transaction !!!");
            }
        } 
        catch(\Exception\AmountNotAddedException $e) 
        {
            return false;
        }
        catch(\Exception\AmountNotRemovedException $e) 
        {
            $removeAmountFromUser = new RemoveAmountFromUser($this->repository);
            $removeAmountFromUser->exec($payee, $amount);

            return false;
        }
        catch(\Exception\TransactionNotAuthenticatedException $e)
        {
            $addAmountToUser = new AddAmountToUser($this->repository);
            $addAmountToUser->exec($payer, $amount);

            $removeAmountFromUser = new RemoveAmountFromUser($this->repository);
            $removeAmountFromUser->exec($payee, $amount);

            return false;
        }
        catch(\Exception $e)
        {
            $message = "Payer: {$payer->id} - Payee: {$payee->id} - Amount: $amount";
            throw new \Exception\TransactionFaultUnknownException($message);
        }

        return true;

    }
}