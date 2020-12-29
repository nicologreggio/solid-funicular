<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
if(isset($_REQUEST['id'])){
    DBC::getInstance()->prepare("DELETE FROM MATERIALS WHERE _ID = ?")->execute([$_REQUEST['id']]);
}
redirectTo('/admin/material/index.php');