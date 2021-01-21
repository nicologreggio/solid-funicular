<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/category/edit.html');

$request = request()->only([
    'name',
    'description',
    'meta-description',
    'menu',
    'page'
]);

$id = request()->only([
    'id'
]);
replaceValues($id, $page);

$stm = DBC::getInstance()->prepare("
    SELECT *
    FROM CATEGORIES
    WHERE `_ID` = ?
");
$stm->execute(array_values($id));
$category = $stm->fetch();
error_if($category === false, 'La categoria cercata non esiste');


if(request()->method() == 'POST' ){
    $err = validate([
        'name' => $request['name'],
        'description' => $request['description'],
        'meta-description' => $request['meta-description'],
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
    // validazione andata a buon fine
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
            $request['name'],
            $request['description'],
            $request['meta-description'],
            $request['menu'] == true,
            $id['id']
        ]);
        if($err === true){
            message("Categoria modificata correttamente");
            redirectTo('/admin/category/index.php?page='.$request['page'].'#category-'.$category->_ID);
        }
    }

    // altrimenti ripristino i valori degli input
    replaceValues([
        "name"=> $request["name"],
        "description" => $request["description"],
        "meta-description" => $request["meta-description"],
        "menu" => ($request['menu'] == true ? 'checked' : ''),
    ], $page, true);

    // mostro gli errori
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
    // altrimenti precompilo gli input
    replaceValues([
        "name" => $category->_NAME,
        "description" => e($category->_DESCRIPTION),
        "meta-description" => $category->_METADESCRIPTION,
        'menu' => $category->_MENU == '1' ? 'checked' : '',
    ], $page, true);
    removeErrorsTag($page);
}
if($category->_MENU == false && DBC::getInstance()->query(
    "SELECT count(*) FROM CATEGORIES WHERE _MENU = 1"
)->fetchColumn() >= 5){
    $page = str_replace("<disabled-menu/>", 'disabled="disabled"', $page);
    $page = str_replace("<menu-message/>", 'Al momento non è possibile inserire questa categoria nel menu in quanto si è già raggiunto il numero massimo di categorie inseribili', $page);
} else {
    $page = str_replace("<disabled-menu/>", '', $page);
    $page = str_replace("<menu-message/>", 'Visualizzazione su menu principale', $page);
    
}
echo $page;