<?php

namespace Transaction\Repository;

interface IAuthenticatedService {
    function authenticate() : string;
}