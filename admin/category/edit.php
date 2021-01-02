<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/category/edit.html');
replaceValues(['id' => $_REQUEST['id'] ?? null], $page);

$stm = DBC::getInstance()->prepare("
    SELECT *
    FROM CATEGORIES
    WHERE `_ID` = ?
");
$stm->execute([
    $_REQUEST['id']
]);
$category = $stm->fetch();
if($category === false){
    error('La categoria cercata non esiste');
} 


if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $err = validate([
        'name' => $_POST['name'] ?? "",
        'description' => $_POST['description'] ?? "",
        'meta-description' => $_POST['meta-description'] ?? "",
    ],[
        'name' => ["required", "min_length:2", "max_length:100"],
        'description' => ["required", "min_length:30"],
        'meta-description' => ["required", "max_length:500", "min_length:30"],
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
            UPDATE CATEGORIES
            SET 
            `_NAME` = ?, 
            `_DESCRIPTION` = ?, 
            `_METADESCRIPTION` = ?, 
            `_MENU` = b?
            WHERE
            `_ID` = ?
        ")->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['meta-description'],
            isset($_POST['menu']),
            $_POST['id']
        ]);
        if($err === true){
            message("Categoria modificata correttamente");
            redirectTo('/admin/category/index.php?page='.$_REQUEST['page']);
        }
    }
    replaceValues([
        "name"=> $_POST["name"],
        "description" => esty($_POST["description"]),
        "meta-description" => $_POST["meta-description"],
        "menu" => (isset($_POST['menu']) ? 'checked' : ''),
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
    replaceValues([
        "name" => $category->_NAME,
        "description" => e($category->_DESCRIPTION),
        "meta-description" => $category->_METADESCRIPTION,
        'menu' => $category->_MENU == '1' ? 'checked' : '',
    ], $page, true);
    removeErrorsTag($page);
}
echo $page;