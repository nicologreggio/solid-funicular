<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/administrator/create.html');
if(request()->method() == 'POST' ){
    $request = request()->only([
        'name',
        'surname',
        'city',
        'address',
        'cap',
        'email',
        'password',
        'confirm'
    ]);
    //$name, $surname, $city, $address, $cap, $email, $password, $confirm
    $register = auth()->register(
        $request['name'],
        $request['surname'],
        $request['city'],
        $request['address'],
        $request['cap'],
        $request['email'],
        $request['password'],
        $request['confirm']
    );
    // registrazione andata a buon fine
    if($register === true){
        redirectIfLogged();
    }
    // altrimenti ripristino i valori inseriti
    replaceValues([
        "email" => $request["email"],
        "name" => $request["name"],
        "surname" => $request["surname"],
        "city" => $request["city"],
        "address" => $request["address"],
        "cap" => $request["cap"],
    ], $page, true);
    // registrazione fallita a lato DB
    if($register === false){
        replaceErrors([
            'db' => "C'è stato un errore durante l'inserimento, riprovare"
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