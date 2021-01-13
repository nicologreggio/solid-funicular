<?php
function error($msg){
    $_SESSION['admin.error'] = $msg;
    redirectTo('/admin/error.php');
}
function error_if(bool $sent, $msg){
    if($sent) error($msg);
}