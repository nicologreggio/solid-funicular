<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
if(isset($_REQUEST['id'])){
    $stm = DBC::getInstance()->prepare("
        SELECT *
        FROM PRODUCTS
        WHERE `_ID` = ?
    ");
    $stm->execute([
        $_REQUEST['id']
    ]);
    $product = $stm->fetch();

    error_if($product === false, 'Il prodotto cercato non esiste');

    if(DBC::getInstance()->prepare("DELETE FROM PRODUCTS WHERE _ID = ?")->execute([$_REQUEST['id']])){
        message("Prodotto eliminato correttamente");
    } 
    else{
        error("Il prodotto cercato non è stato trovato");
    }
}
redirectTo('/admin/product/index.php');