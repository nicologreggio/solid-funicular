<?php

require_once(__DIR__."/../user/user.service.php");

function login(string $email, string $password) : bool
{
    return UserService::login($email, $password);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' )
{
    if(login($_POST['email'], $_POST['password']))
    {
        echo "log";
    }
    else
    {
        echo "not logged";
    }
}
else
{
    echo file_get_contents('./login.html');
}

