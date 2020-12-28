<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = file_get_contents('../template_html/administrator/create.html');
if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    //$name, $surname, $city, $address, $cap, $email, $password, $confirm
    $register = auth()->register(
        $_POST['name'] ?? "",
        $_POST['surname'] ?? "",
        $_POST['city'] ?? "",
        $_POST['address'] ?? "",
        $_POST['cap'] ?? "",
        $_POST['email'] ?? "",
        $_POST['password'] ?? "",
        $_POST['confirm'] ?? ""
    );
    // registrazione andata a buon fine
    if($register === true){
        redirectIfLogged();
    }
    $page = str_replace("<value-email/>", $_POST["email"], $page);
    $page = str_replace("<value-name/>", $_POST["name"], $page);
    $page = str_replace("<value-surname/>", $_POST["surname"], $page);
    $page = str_replace("<value-city/>", $_POST["city"], $page);
    $page = str_replace("<value-address/>", $_POST["address"], $page);
    $page = str_replace("<value-cap/>", $_POST["cap"], $page);
    // registrazione fallita a lato DB
    if($register === false){
        $page = str_replace('<error-db/>', "C'è stato un errore durante l'inserimento, riprovare", $page);
        $page = str_replace("<error-email/>", "", $page);
        $page = str_replace("<error-password/>", "", $page);
        $page = str_replace("<error-confirm/>", "", $page);
        $page = str_replace("<error-name/>", "", $page);
        $page = str_replace("<error-surname/>", "", $page);
        $page = str_replace("<error-city/>", "", $page);
        $page = str_replace("<error-address/>", "", $page);
        $page = str_replace("<error-cap/>", "", $page);
    } 
    // registrazione fallita a lato validazione
    else if(is_array($register)){
        $page = str_replace('<error-db/>', "", $page); // rimuovo placeholder per errore db
        foreach($register as $k => $errors){
            $msg = "<ul class='errors-list'>";
            foreach($errors as $error){
                $msg .= "<li> $error </li>";
            }
            $msg .= "</ul>";
            $page = str_replace("<error-$k/>", $msg, $page);
        }
    }
}
else {
    $page = str_replace('<error-db/>', "", $page);
    $page = str_replace("<error-email/>", "", $page);
    $page = str_replace("<error-password/>", "", $page);
    $page = str_replace("<error-confirm/>", "", $page);
    $page = str_replace("<error-name/>", "", $page);
    $page = str_replace("<error-surname/>", "", $page);
    $page = str_replace("<error-city/>", "", $page);
    $page = str_replace("<error-address/>", "", $page);
    $page = str_replace("<error-cap/>", "", $page);
    $page = str_replace("<value-email/>", '', $page);
    $page = str_replace("<value-name/>", '', $page);
    $page = str_replace("<value-surname/>", '', $page);
    $page = str_replace("<value-city/>", '', $page);
    $page = str_replace("<value-address/>", '', $page);
    $page = str_replace("<value-cap/>", '', $page);

}
echo $page;
/*
<error-email/>
<error-password/>
<error-confirm/>
<error-name/>
<error-surname/>
<error-city/>
<error-address/>
<error-cap/>

*/