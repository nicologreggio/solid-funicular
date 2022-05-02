<?php
require_once(__DIR__.'/../inc/imports.php');
function base(){
    return str_replace(PHP_EOL, '', file_get_contents(__DIR__.'/../../.base_path') ?? "");
}
function redirectIfNotLogged() : void{
    if(!auth()->isLogged()){
        header("Location: ".base()."/admin/login.php");
        echo "Ti stiamo reindirizzando al login.";
        die();
    }
}
function redirectIfLogged() : void{
    if(auth()->isLogged()){
        header("Location: ".base()."/admin/home.php");
        echo "Ti stiamo reindirizzando alla home.";
        die();
    }
}

function redirectTo($url){
    echo "Ti stiamo reindirizzando a $url.";
    header("Location: ".base().$url);
    die();
}