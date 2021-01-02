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
    replaceValues([
        "email" => $_POST["email"],
        "name" => $_POST["name"],
        "surname" => $_POST["surname"],
        "city" => $_POST["city"],
        "address" => $_POST["address"],
        "cap" => $_POST["cap"],
    ], $page, true);
    // registrazione fallita a lato DB
    if($register === false){
        replaceErrors([
            '<error-db/>' => "C'è stato un errore durante l'inserimento, riprovare"
        ], $page, true);
    } 
    // registrazione fallita a lato validazione
    else if(is_array($register)){
        replaceErrors($register, $page, true);
    }
}
else {
    removeErrorsTag($page);
    removeValuesTag($page);

}
echo $page;