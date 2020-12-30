<?php

require_once(__DIR__."/../user/user.service.php");

function signup(string $email, string $name, string $surname, string $password, string $city, string $address, int $cap) : bool
{
    echo UserService::login($email, $password);
    
    return true;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' )
{
    if(signup($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['password'], $_POST['city'], $_POST['address'], $_POST['cap']))
    {
        echo "signup";
    }
    else
    {
        echo "not signup";
    }
}
else
{
    echo file_get_contents('./signup.html');
}
