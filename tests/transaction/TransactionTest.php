<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Transaction\Business\AddAmountToUser;
use User\Client;
use User\Logist;
use Transaction\Business\SendMoneyToUser;
use Transaction\Business\GetUserBalance;
use Transaction\Repository\AuthenticatedServiceMock;
use Transaction\Repository\BalanceRepositoryMock;
use User\Repository\SaveUser;
use User\Repository\UserRepositoryMock;

final class TransactionTest extends TestCase
{
    public static $balanceRepository;
    public static $userRepository;
    public static $authenticatedService;
    public static $notAuthenticatedService;

    public static $logist;
    public static $client1;
    public static $client2;

    public static function setUpBeforeClass()
    {
        self::$balanceRepository = new BalanceRepositoryMock();
        self::$userRepository = new UserRepositoryMock();
        self::$authenticatedService = new AuthenticatedServiceMock();
        self::$notAuthenticatedService = new AuthenticatedServiceMock(true);
        
        self::$logist = new Logist("Tiago Simão", "111.222.333-45", "tiago.simao@email.com", "123456");
        self::$client1 = new Client("Eduardo Tomé", "555.444.333-21", "eduardo.tome@email.com", "123456");
        self::$client2 = new Client("André Gusmão", "999.888.777-56", "andre.gusmao@email.com", "123456");

        $saveUser = new SaveUser(self::$userRepository);
        $saveUser->exec(self::$logist);
        $saveUser->exec(self::$client1);
        $saveUser->exec(self::$client2);

        $addAmount = new AddAmountToUser(self::$balanceRepository);

        $addAmount->exec(self::$logist, 100);
        $addAmount->exec(self::$client1, 50);
        $addAmount->exec(self::$client2, 70);
    }

    public function testSendMoneyToUserFailsIfLogistSendMoney() : void
    {
        $this->expectException(\Exception\LogistSendMoneyException::class);

        $sendMoneyToUser = new SendMoneyToUser(self::$balanceRepository, self::$authenticatedService);
        $sendMoneyToUser->exec(self::$logist, self::$client1, 50.00);
    }

    public function testSendMoneyToUserFailsIfClientHasNotEnoughBalance() : void
    {
        $this->expectException(\Exception\UserHasNotEnoughBalanceException::class);

        $sendMoneyToUser = new SendMoneyToUser(self::$balanceRepository, self::$authenticatedService);
        $sendMoneyToUser->exec(self::$client1, self::$logist, 51.00);
    }

    public function testSendMoneyToUserFailsIfAuthorizedServiceFails() : void
    {
        $sendMoneyToUser = new SendMoneyToUser(self::$balanceRepository, self::$notAuthenticatedService);
        
        $this->assertFalse($sendMoneyToUser->exec(self::$client1, self::$logist, 10.00));

        $getUserBalance = new GetUserBalance(self::$balanceRepository);
        $logistBalance = $getUserBalance->exec(self::$logist->id);
        $client1Balance = $getUserBalance->exec(self::$client1->id);

        $this->assertEquals($logistBalance->value, 100);
        $this->assertEquals($client1Balance->value, 50);
    }

    public function testSendMoneyToUserSuccess() : void
    {
        $sendMoneyToUser = new SendMoneyToUser(self::$balanceRepository, self::$authenticatedService);
        $sendMoneyToUser->exec(self::$client1, self::$logist, 10.00);

        $getUserBalance = new GetUserBalance(self::$balanceRepository);
        $balance = $getUserBalance->exec(self::$logist->id);

        $this->assertEquals($balance->value, 110);
    }

    public function testSendMoneyToUserDiscountClientBalanceSucess() : void
    {
        $getUserBalance = new GetUserBalance(self::$balanceRepository);
        $balance = $getUserBalance->exec(self::$client1->id);

        $this->assertEquals($balance->value, 40.00);
    }
}