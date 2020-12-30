<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
if(isset($_REQUEST['id'])){
    if(DBC::getInstance()->prepare("DELETE FROM CATEGORIES WHERE _ID = ?")->execute([$_REQUEST['id']])){
        message("Categoria eliminata correttamente");
    } else {
        error("La categoria cercata non è stata trovata");
    }
}
redirectTo('/admin/category/index.php');