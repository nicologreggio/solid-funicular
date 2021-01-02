<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/category/create.html');
if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $err = validate([
        'name' => $_POST['name'] ?? "",
        'description' => $_POST['description'] ?? "",
        'meta-description' => $_POST['meta-description'] ?? "",
    ],[
        'name' => ["required", "min_length:2", "max_length:100"],
        'description' => ["required", "min_length:30"],
        'meta-description' => ["required", "min_length:30", "max_length:500"],
    ],[
        "name.required" => "E' obbligatorio inserire un nome",
        "name.min_length" => "Il nome inserito deve essere lungo almeno 2 caratteri",
        "name.max_length" => "Il nome inserito può essere lungo al massimo 100 caratteri",

        "meta-description.required" => "E' obbligatorio inserire una meta-descrizione",
        "meta-description.min_length" => "La meta descrizione deve essere lunga almeno 30 caratteri",
        "meta-description.max_length" => "La meta descrizione può essere lunga al massimo 500 caratteri",
        
        "description.required" => "E' obbligatorio inserire una descrizione",
        "description.min_length" => "La descrizione deve essere lunga almeno 30 caratteri",
    ]);
    if($err === true){
        $err = DBC::getInstance()->prepare("
            INSERT INTO CATEGORIES(`_NAME`, `_DESCRIPTION`, `_METADESCRIPTION`, `_MENU`) VALUES
            (?, ?, ?, b?)
        ")->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['meta-description'],
            isset($_POST['menu'])
        ]);
        if($err === true){
            message("Categoria creata correttamente");
            redirectTo('/admin/category/index.php');
        }
    }

    replaceValues([
        "name" => $_POST["name"],
        "description" => $_POST["description"],
        "meta-description" => $_POST["meta-description"],
        'menu' => (isset($_POST['menu']) ? 'checked' : ''),
    ], $page);

    if($err === false){
        replaceErrors([
            '<error-db/>' => "C'è stato un errore durante l'inserimento"
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