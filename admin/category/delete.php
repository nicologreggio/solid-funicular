<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();

if(isset($_REQUEST['id'])){
    $stm = DBC::getInstance()->prepare("
        SELECT *
        FROM CATEGORIES
        WHERE `_ID` = ?
    ");
    $stm->execute([$_REQUEST['id']]);
    $category = $stm->fetch();
    error_if($category === false, 'La categoria cercata non esiste'); 

    if(DBC::getInstance()->prepare("DELETE FROM CATEGORIES WHERE _ID = ?")->execute([$_REQUEST['id']])){
        message("Categoria eliminata correttamente");
    } else {
        error("La categoria cercata non è stata trovata");
    }
}
redirectTo('/admin/category/index.php');