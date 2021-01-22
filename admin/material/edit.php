<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/material/edit.html');

$id = request()->only(['id']);
$request = request()->only([
    'name',
    'description',
    'id',
    'page'
]);
replaceValues($id, $page);

$stm = DBC::getInstance()->prepare("
    SELECT *
    FROM MATERIALS
    WHERE `_ID` = ?
");
$stm->execute([
    $id['id']
]);
$material = $stm->fetch();
error_if($material === false, 'Il materiale cercato non esiste');
 


if(request()->method() == 'POST' ){
    $err = validate([
        'name' => $request['name'] ?? "",
        'description' => $request['description'] ?? "",
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
    // validazione andata a buon fine
    if($err === true){
        $err = DBC::getInstance()->prepare("
            UPDATE MATERIALS
            SET 
            `_NAME` = ?, 
            `_DESCRIPTION` = ?
            WHERE
            `_ID` = ?
        ")->execute([
            $request['name'],
            $request['description'],
            $request['id']
        ]);
        if($err === true){
            message("Materiale modificato correttamente");
            redirectTo('/admin/material/index.php?page='.$request['page'].'#material-'.$material->_ID);
        }
    }

    // altrimenti ripristino i valori degli input
    replaceValues([
        "name" => $request["name"],
        "description" => $request["description"]
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
    // precompilo i campi input 
    replaceValues([
        "name" => $material->_NAME, 
        "description" => $material->_DESCRIPTION, 
    ], $page, true);
    removeErrorsTag($page); 
}
echo $page;