<?php
require_once(__DIR__.'/inc/header_php.php');
redirectIfLogged();
if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    if(auth()->login($_POST['email'], $_POST['password']) === true){
        redirectIfLogged();
    }
}
echo file_get_contents('template_html/login.html');
