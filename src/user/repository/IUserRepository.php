<?php 

namespace User\Repository;

use User\User;

Interface IUserRepository
{
    function insertUser(User $user);

    function getUserByEmail(string $email);

    function getUserByDocument(string $document);
}