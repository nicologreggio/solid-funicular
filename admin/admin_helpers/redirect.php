<?php
require_once(__DIR__.'/../imports.php');
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