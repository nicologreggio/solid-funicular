<?php
function error($msg){
    $_SESSION['admin.error'] = $msg;
    redirectTo('/admin/error.php');
}