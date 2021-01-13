<?php
require_once(__DIR__.'/../inc/imports.php');
function base(){
    return file_get_contents('../../.base_path') ?? "";
}
function redirectIfNotLogged() : void{
    if(!auth()->isLogged()){
        echo "Ti stiamo redirezionando al login.";
        header("Location: ".base()."/admin/login.php");
        die();
    }
}
function redirectIfLogged() : void{
    if(auth()->isLogged()){
        echo "Ti stiamo redirezionando alla home.";
        header("Location: ".base()."/admin/home.php");
        die();
    }
}

function redirectTo($url){
    echo "Ti stiamo redirezionando a $url.";
    header("Location: ".base().$url);
    die();
}