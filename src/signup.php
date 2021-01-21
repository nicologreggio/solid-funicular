<?php
session_start();

require_once(__DIR__."/../helpers/validator.php");
require_once(__DIR__."/utils/utils.php");
require_once(__DIR__."/php/user/user.service.php");

function signup(string $email, string $name, string $surname, string $password, string $city, string $address, int $cap) : bool
{
    $user = UserService::signup($email, $name, $surname, $city, $address, $cap, $password);
    $exist = $user != null;

    if($exist) 
    {
        $_SESSION['user'] = $user->getId();
        $_SESSION['username'] = $user->getName().' '.$user->getSurname();
    }

    return $exist;
}

function validateSignupData(string $email, string $name, string $surname, string $password, string $confirm, string $city, string $address, string $cap)
{
    $err = validate([
        'email' => $email,
        'name' => $name,
        'surname' => $surname,
        'password' => $password,
        'confirm' => $confirm,
        'city' => $city,
        'address' => $address,
        'cap' => $cap
    ], [
        'email' => ['required', 'email', 'max_length:100', 'unique:USERS,_EMAIL'],
        'name' => ['required', 'alphabetic', 'max_length:50'],
        'surname' => ['required', 'alphabetic', 'max_length:100'],
        'city' => ['required', 'max_length:100'],
        'address' => ['required', 'max_length:100'],
        'cap' => ['required', 'length:5', 'integer'],
        'password' => ['required', 'password'],
        'confirm' => ['required', 'equals:password']
    ], [
        'email.required' => "E' obbligatorio inserire una email",
        'email.email' => "L'email inserita non è valida",
        'email.max_length' => "L'email può essere lunga al massimo 100 caratteri",
        'email.unique' => "L'email è già in uso",

        'name.required' => "È obbligatorio inserire un nome (una parola composte da lettere dell'alfabeto)",
        'name.alphabetic' => "Il nome inserito può contenere solo lettere dell'alfabeto",
        'name.max_length' => "Il nome inserito può essere lungo al massimo 50 caratteri", 

        'surname.required' => "È obbligatorio inserire un cognome (una parola composta da lettere dell'alfabeto)",
        'surname.alphabetic' => "Il nome inserito può contenere solo lettere dell'alfabeto",
        'surname.max_length' => "Il cognome inserito può essere lungo al massimo 100 caratteri", 
        
        'password' => "È obbligatorio inserire una password",
        'password.password' => "La password inserita non è valida",
        
        'confirm.required' => "È obbligatorio inserire la verifica",
        'confirm.equals' => "La password e la password di conferma non corrispondono",

        'city.required' => "E' obbligatorio inserire una città",
        'city.max_length' => "Il nome della città inserita può essere al massimo lungo 100 caratteri",

        'address.required' => "E' obbligatorio inserire un indirizzo",
        'address.max_length' => "L'indirizzo inserito può essere lungo al massimo 100 caratteri",

        'cap.required' => "È obbligatorio inserire un CAP",
        'cap.length' => "Il CAP deve essere lungo esattamente 5 caratteri numerici",
        'cap.integer' => "Il CAP deve essere composto da soli numeri"
    ]);

    return $err;
}

function cleanPage($page)
{
    $page = str_replace("<value-email/>", "", $page);
    $page = str_replace("<value-name/>", "", $page);
    $page = str_replace("<value-surname/>", "", $page);
    $page = str_replace("<value-password/>", "", $page);
    $page = str_replace("<value-confirm-password/>", "", $page);
    $page = str_replace("<value-city/>", "", $page);
    $page = str_replace("<value-address/>", "", $page);
    $page = str_replace("<value-cap/>", "", $page);

    $page = str_replace("<error-email/>", "", $page);
    $page = str_replace("<error-name/>", "", $page);
    $page = str_replace("<error-surname/>", "", $page);
    $page = str_replace("<error-password/>", "", $page);
    $page = str_replace("<error-confirm-password/>", "", $page);
    $page = str_replace("<error-city/>", "", $page);
    $page = str_replace("<error-address/>", "", $page);
    $page = str_replace("<error-cap/>", "", $page);

    return $page;
}

function fillPageWithErrorAndValue($page, $err)
{
    $page = str_replace("<value-email/>", $_POST['email'], $page);
    $page = str_replace("<value-name/>", $_POST['name'], $page);
    $page = str_replace("<value-surname/>", $_POST['surname'], $page);
    $page = str_replace("<value-password/>", $_POST['password'], $page);
    $page = str_replace("<value-confirm-password/>", $_POST['confirm-password'], $page);
    $page = str_replace("<value-city/>", $_POST['city'], $page);
    $page = str_replace("<value-address/>", $_POST['address'], $page);
    $page = str_replace("<value-cap/>", $_POST['cap'], $page);

    if($err === true)
    {
        $page = str_replace('<error-db/>', "C'è stato un errore nel database", $page);
        $page = str_replace("<error-email/>", "", $page);
        $page = str_replace("<error-name/>", "", $page);
        $page = str_replace("<error-surname/>", "", $page);
        $page = str_replace("<error-password/>", "", $page);
        $page = str_replace("<error-confirm-password/>", "", $page);
        $page = str_replace("<error-city/>", "", $page);
        $page = str_replace("<error-address/>", "", $page);
        $page = str_replace("<error-cap/>", "", $page);
    } else if(is_array($err))
    {
        $page = fillPageWithError($page, $err);
    }

    return $page;
}

$page=file_get_contents('./signup/signup.html');
$page=fillHeader($page);
$page=str_replace('<breadcrumbs-location />', 'Registrati', $page);
$page=str_replace('<a href="./login.php"><img id="login" src="../images/icons/login.png" alt="Icona utente per login" /></a>', '', $page);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $err = validateSignupData($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['password'], $_POST['confirm-password'], $_POST['city'], $_POST['address'], $_POST['cap']);

    if($err === true)
    {
        if(signup($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['password'], $_POST['city'], $_POST['address'], $_POST['cap']))
        {
            header('Location: ' . $_SESSION['HTTP_REFERER']);
        }
    }
    else
    {
        echo fillPageWithErrorAndValue($page, $err);
    }
}
else
{
    echo cleanPage($page);
}
