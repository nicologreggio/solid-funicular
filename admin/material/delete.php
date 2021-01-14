<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
if(isset($_REQUEST['id'])){
    $stm = DBC::getInstance()->prepare("
        SELECT *
        FROM MATERIALS
        WHERE `_ID` = ?
    ");
    $stm->execute([
        $_REQUEST['id']
    ]);
    $material = $stm->fetch();
    error_if($material === false, 'Il materiale cercato non esiste');

    if(DBC::getInstance()->prepare("DELETE FROM MATERIALS WHERE _ID = ?")->execute([$_REQUEST['id']])){
        message("Materiale eliminato correttamente");
    }
    else{
        error("Il materiale cercato non è stato trovato");
    }
}
redirectTo('/admin/material/index.php');