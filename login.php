<?php
session_start();

require_once(__DIR__."/helpers/validator.php");
require_once(__DIR__."/utils/utils.php");
require_once(__DIR__."/php/user/user.service.php");

function login(string $email, string $password)
{
    $user = UserService::login($email, $password);
    $exist = $user != null;

    if($exist) 
    {
        $_SESSION['user'] = $user->getId();
        $_SESSION['username'] = $user->getName().' '.$user->getSurname();
    }

    return $exist;
}

function validateLoginData(string $email, string $password)
{
    $err = validate([
        'email' => $email,
        'password' => $password
    ], [
        'email' => ['required'],
        'password' => ['required']
    ], [
        'email.required' => "L'email non è stata inserita",

        'password.required' => "La password non è stata inserita",
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

    if(is_array($err))
    {
        $page = fillPageWithError($page, $err);
    }
    
    $page = str_replace('<error-email/>', "", $page);
    $page = str_replace('<error-password/>', "", $page);

    return $page;
}

function setHttpReferFromLogin()
{
    if(!strpos($_SERVER['HTTP_REFERER'], 'signup.php'))
    {
        $_SESSION['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
    }
}


$page=file_get_contents('./login/login.html');
$page=fillHeader($page);
$page=str_replace('<breadcrumbs-location />', 'Accedi', $page);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $err = validateLoginData($_POST['email'], $_POST['password']);
    
    if($err === true)
    {
        if(login($_POST['email'], $_POST['password']))
        {
            header('Location: ' . $_SESSION['HTTP_REFERER']);
        }
        else
        {
            echo fillPageWithErrorAndValue($page, ["password" => [ "Email o password sbagliata" ]]);
        }
    }
    else
    {
        echo fillPageWithErrorAndValue($page, $err);
    }
}
else
{
    setHttpReferFromLogin();

    echo cleanPage($page);
}
