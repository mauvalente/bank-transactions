<?php

namespace Transaction\Business;

use Transaction\Repository\IAuthenticatedService;
use Transaction\Repository\AuthenticatedServiceConstants;

class CheckAuthenticatedService
{
    private $authenticatedService;

    public function __construct(IAuthenticatedService $authenticatedService)
    {
        $this->authenticatedService = $authenticatedService;
    }
    public function exec()
    {
        $data = null;
        try {
            $data = $this->authenticatedService->authenticate();
        } catch (\Exception $e) {
            return false;
        }

        $result = json_decode($data);

        return ( isset($result->message) && $result->message == AuthenticatedServiceConstants::SUCCESS_MESSAGE );
    }
}