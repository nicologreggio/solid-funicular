<?php
require_once(__DIR__.'/../inc/imports.php');
function replaceValues(array $values, string &$page, bool $strip_remaining = false){
    foreach($values as $k => $value){
        $page = str_replace("<value-$k/>", $value, $page);
    }
    if($strip_remaining){
        removeValuesTag($page);
    }
}
function removeValuesTag(string &$page){
    $page = preg_replace("/\<value\-[a-zA-z\-]*\/\>/", "", $page);
}