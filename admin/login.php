<?php
require_once(__DIR__.'/inc/header_php.php');
redirectIfLogged();
$page = file_get_contents('template_html/login.html');
if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    if(auth()->login($_POST['email'], $_POST['password']) === true){
        redirectIfLogged();
    }
    else {
        $page = str_replace('<error-login/>', '<p class="error">L\' cercato non è stato trovato</p>', $page);
    }
}
echo $page;
