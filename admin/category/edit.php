<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = file_get_contents('../template_html/category/edit.html');
$page = str_replace('<value-id/>', $_REQUEST['id'], $page);

if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $err = validate([
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'meta-description' => $_POST['meta-description'],
    ],[
        'name' => ["required", "min_length:2", "max_length:100"],
        'description' => ["required", "max_length:500", "min_length:30"],
        'meta-description' => ["required", "min_length:30"],
    ],[
        "name.required" => "E' obbligatorio inserire un nome",
        "name.min_length" => "Il nome inserito deve essere lungo almeno 2 caratteri",
        "name.max_length" => "Il nome inserito può essere lungo al massimo 50 caratteri",
        "meta-description.required" => "E' obbligatorio inserire una meta-descrizione",
        "meta-description.min_length" => "La meta descrizione deve essere lunga almeno 30 caratteri",
        "meta-description." => "La meta descrizione può essere lunga al massimo 500 caratteri",
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
            redirectTo('/admin/category/index.php');
        }
    }
    $page = str_replace("<value-name/>", $_POST["name"], $page);
    $page = str_replace("<value-description/>", $_POST["description"], $page);
    $page = str_replace("<value-meta-description/>", $_POST["meta-description"], $page);
    $page = str_replace('<value-menu/>', (isset($_POST['menu']) ? 'checked' : ''), $page);

    if($err === false){
        $page = str_replace('<error-db/>', "C'è stato un errore durante l'inserimento", $page);
        $page = str_replace('<error-name/>', "", $page);
        $page = str_replace('<error-description/>', "" , $page);
        $page = str_replace('<error-meta-description/>', "" , $page);
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
    $page = str_replace("<value-name/>", $category->_NAME, $page);
    $page = str_replace("<value-description/>", $category->_DESCRIPTION, $page);
    $page = str_replace("<value-meta-description/>", $category->_METADESCRIPTION, $page);
    $page = str_replace('<value-menu/>', $category->_MENU == '1' ? 'checked' : '', $page);
    $page = str_replace('<error-db/>', "", $page);
    $page = str_replace('<error-name/>', "", $page);
    $page = str_replace('<error-description/>', "" , $page);
    $page = str_replace('<error-meta-description/>', "" , $page);
}
echo $page;