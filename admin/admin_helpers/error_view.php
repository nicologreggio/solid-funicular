<?php
function replaceErrors(array $err, string &$page, bool $strip_remaining = false){
    foreach($err as $k => $errors){
        $msg = "<ul class='errors-list'>";
        foreach($errors as $error){
            $msg .= "<li> $error </li>";
        }
        $msg .= "</ul>";
        $page = str_replace("<error-$k/>", $msg, $page);
    }
    if($strip_remaining){
        removeErrorsTag($page);
    }
}
function removeErrorsTag(string &$page){
    $page = preg_replace("/\<error\-[a-zA-z\-]*\/\>/", "", $page);
}