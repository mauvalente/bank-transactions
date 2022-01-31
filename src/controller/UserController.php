<?php

namespace Controller;

class UserController
{
    public function list()
    {
        echo "<form method='post'><input type='text' name='nome' /><input type='submit' name='ok' value='ok'></form>";
    }

    public function add($post)
    {
        echo "<pre>";
        print_r($post);
    }

    public function update($user)
    {
        print_r($user);
    }
}