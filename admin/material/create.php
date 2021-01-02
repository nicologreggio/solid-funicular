<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/material/create.html');
if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $err = validate([
        'name' => $_POST['name'] ?? "",
        'description' => $_POST['description'] ?? "",
    ],[
        'name' => ["required", "min_length:2", "max_length:50"],
        'description' => ["required", "min_length:10", "max_length:200"],
    ],[
        "name.required" => "E' obbligatorio inserire un nome",
        "name.min_length" => "Il nome inserito deve essere lungo almeno 2 caratteri",
        "name.max_length" => "Il nome inserito può essere lungo al massimo 50 caratteri",
        
        "description.required" => "E' obbligatorio inserire una descrizione",
        "description.min_length" => "La descrizione deve essere lunga almeno 10 caratteri caratteri",
        "description.max_length" => "La descrizione può essere lunga al massimo 200 caratteri",
    ]);
    if($err === true){
        $err = DBC::getInstance()->prepare("
            INSERT INTO MATERIALS(`_NAME`, `_DESCRIPTION`) VALUES
            (?, ?)
        ")->execute([
            $_POST['name'],
            $_POST['description'],
        ]);
        if($err === true){
            message("Materiale creato correttamente");
            redirectTo('/admin/material/index.php');
        }
    }
    replaceValues([
        "name" => $_POST["name"],
        "description" => $_POST["description"]
    ], $page, true);

    if($err === false){
        replaceErrors([
            'db' => "C'è stato un errore durante l'inserimento"
        ], $page, true);
    }
    else if(is_array($err)){
        replaceErrors($err, $page, true);
     }
}
else {
    removeValuesTag($page);
    removeErrorsTag($page);
}
echo $page;