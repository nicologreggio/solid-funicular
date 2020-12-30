<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/material/edit.html');
$page = str_replace('<value-id/>', $_REQUEST['id'], $page);

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
            UPDATE MATERIALS
            SET 
            `_NAME` = ?, 
            `_DESCRIPTION` = ?
            WHERE
            `_ID` = ?
        ")->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['id']
        ]);
        if($err === true){
            message("Materiale modificato correttamente");
            redirectTo('/admin/material/index.php');
        }
    }
    $page = str_replace("<value-name/>", $_POST["name"], $page);
    $page = str_replace("<value-description/>", $_POST["description"], $page);

    if($err === false){
        $page = str_replace('<error-db/>', "C'è stato un errore durante l'inserimento", $page);
        $page = str_replace('<error-name/>', "", $page);
        $page = str_replace('<error-description/>', "" , $page);
    }
    else if(is_array($err)){
        $page = str_replace('<error-db/>', "", $page); // rimuovo placeholder per errore db
        foreach($err as $k => $errors){
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
    $stm = DBC::getInstance()->prepare("
        SELECT *
        FROM MATERIALS
        WHERE `_ID` = ?
    ");
    $stm->execute([
        $_REQUEST['id']
    ]);
    $material = $stm->fetch();
    if($material === false){
        error('Il materiale cercato non esiste');
    } 
    $page = str_replace("<value-name/>", $material->_NAME, $page);
    $page = str_replace("<value-description/>", $material->_DESCRIPTION, $page);
    $page = str_replace('<error-db/>', "", $page);
    $page = str_replace('<error-name/>', "", $page);
    $page = str_replace('<error-description/>', "" , $page);
}
echo $page;