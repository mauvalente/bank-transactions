<?php

namespace Transaction\Repository;

class AuthenticatedServiceMock implements IAuthenticatedService
{
    private $fail;

    public function __construct($fail = false)
    {
        $this->fail = $fail;
    }

    public function authenticate() : string
    {
        if ($this->fail) {
            return '{"message" : "Não Autorizado"}';
        }
        
        return '{"message" : "Autorizado"}';
    }
}