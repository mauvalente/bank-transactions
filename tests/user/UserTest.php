<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use User\Repository\UserRepositoryMock;
use User\Repository\CheckUniqueEmail;
use User\Repository\CheckUniqueDocument;
use User\Repository\SaveUser;
use User\User;
use User\Client;
use User\Logist;

final class UserTest extends TestCase
{
    public static $userRepository;

    public static function setUpBeforeClass()
    {
        self::$userRepository = new UserRepositoryMock();
    }

    public function testCreateClientUser() : void
    {
        $client = new Client("Tiago da Silva", "000.000.000-55", "client@email.com", "password");

        $saveUser = new SaveUser(self::$userRepository);
        $saveUser->exec($client);

        $this->assertEquals(
            $client->type,
            User::CLIENT
        );
    }

    public function testCreateLogistUser() : void
    {
        $logist = new Logist("Tiago da Silva", "111.000.000-55", "logist@email.com", "password");

        $saveUser = new SaveUser(self::$userRepository);
        $saveUser->exec($logist);

        $this->assertEquals(
            $logist->type,
            User::LOGIST
        );
    }

    public function testAddDuplicatedEmail() : void
    {
        $checkUniqueEmail = new CheckUniqueEmail(self::$userRepository);
        
        $this->assertFalse($checkUniqueEmail->exec("client@email.com"));
    }

    public function testAddDuplicatedDocument() : void
    {
        $checkUniqueDocument = new CheckUniqueDocument(self::$userRepository);
        
        $this->assertFalse($checkUniqueDocument->exec("111.000.000-55"));
    }
}