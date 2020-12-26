<?php
require_once(__DIR__.'/../inc/imports.php');
function redirectIfNotLogged() : void{
    if(!auth()->isLogged()){
        echo "Ti stiamo redirezionando al login.";
        header("Location: /admin/login.php");
        die();
    }
}
function redirectIfLogged() : void{
    if(auth()->isLogged()){
        echo "Ti stiamo redirezionando alla home.";
        header("Location: /admin/home.php");
        die();
    }
}

function redirectTo($url){
    echo "Ti stiamo redirezionando a $url.";
    header("Location: $url");
    die();
}