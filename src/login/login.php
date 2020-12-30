<?php

require_once(__DIR__."/../../helpers/validator.php");
require_once(__DIR__."/../user/user.service.php");
require_once(__DIR__."/../utils/utils.php");

function login(string $email, string $password) : bool
{
    $user = UserService::login($email, $password);
    $exist = $user != null;

    if($exist) $_SESSION['user'] = $user;

    return $exist;
}

function validateLoginData(string $email, string $password)
{
    $err = validate([
        'email' => $email,
        'password' => $password
    ], [
        'email' => ['email', 'required'],
        'validate' => ['required', 'password']
    ], [
        'email.required' => "È obbligatorio inserire una email",
        'email.email' => "L'email inserita non è valida",

        'password.required' => "È obbligatorio inserire una password"
    ]);

    return $err;
}

function cleanPage($page)
{
    $page = str_replace("<value-email/>", "", $page);
    $page = str_replace("<value-password/>", "", $page);

    $page = str_replace("<error-email/>", "", $page);
    $page = str_replace("<error-password/>", "", $page);

    return $page;
}

function fillPageWithErrorAndValue($page, $err)
{
    $page = str_replace("<value-email/>", $_POST['email'], $page);
    $page = str_replace("<value-password/>", $_POST['password'], $page);

    if($err === false)
    {
        $page = str_replace('<error-db/>', "C'è stato un errore durante l'inserimento", $page);
        $page = str_replace('<error-email/>', "", $page);
        $page = str_replace('<error-password/>', "", $page);
    } else if(is_array($err))
    {
        $page = fillPageWithError($page, $err);
    }

    return $page;
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $err = validateLoginData($_POST['email'], $_POST['password']);
    if($err === false)
    {
        if(login($_POST['email'], $_POST['password']))
        {
            echo "log";
        }
        else
        {
            echo "Not exist";
        }
    }
    else
    {
        echo fillPageWithErrorAndValue(file_get_contents('./login.html'), $err);
    }
}
else
{
    echo cleanPage(file_get_contents('./login.html'));
}
