<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
if(isset($_REQUEST['id'])){
    if(DBC::getInstance()->prepare("DELETE FROM PRODUCTS WHERE _ID = ?")->execute([$_REQUEST['id']])){
        message("Prodotto eliminato correttamente");
    } 
    else{
        error("Il prodotto cercato non è stato trovato");
    }
}
redirectTo('/admin/product/index.php');