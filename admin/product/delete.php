<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
if(isset($_REQUEST['id'])){
    DBC::getInstance()->prepare("DELETE FROM PRODUCTS WHERE _ID = ?")->execute([$_REQUEST['id']]);
}
redirectTo('/admin/product/index.php');