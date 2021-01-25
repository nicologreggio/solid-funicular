<?php
require_once(__DIR__.'/../inc/imports.php');
function base(){
    return str_replace(PHP_EOL, '', file_get_contents(__DIR__.'/../../.base_path') ?? "");
}
function redirectIfNotLogged() : void{
    if(!auth()->isLogged()){
        echo "Ti stiamo reindirizzando al login.";
        header("Location: ".base()."/admin/login.php");
        die();
    }
}
function redirectIfLogged() : void{
    if(auth()->isLogged()){
        echo "Ti stiamo reindirizzando alla home.";
        header("Location: ".base()."/admin/home.php");
        die();
    }
}

function redirectTo($url){
    echo "Ti stiamo reindirizzando a $url.";
    header("Location: ".base().$url);
    die();
}