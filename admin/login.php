<?php
require_once(__DIR__.'/inc/header_php.php');
redirectIfLogged();
$page = file_get_contents('template_html/login.html');
if(request()->method() == 'POST' ){
    if(auth()->login($_POST['email'], $_POST['password']) === true){
        redirectIfLogged();
    }
    else {
        $page = str_replace('<error-login/>', '<p class="error">L\'utente cercato non è stato trovato o i dati inseriti non son validi</p>', $page);
        $page = str_replace('<value-email/>',$_POST['email'] , $page);
    }
}
removeErrorsTag($page);
removeValuesTag($page);
echo $page;
