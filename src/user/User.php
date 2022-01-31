<?php declare(strict_types=1);

namespace User;

abstract class User
{
    public $id;
    public $name;
    public $document;
    public $email;
    public $password;

    CONST LOGIST = 'logista';
    CONST CLIENT = 'comum';

    abstract function setUserType() : void;

    public function __construct(string $name, string $document, string $email, string $password)
    {
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
        $this->password = $password;

        $this->setUserType();
    }
}