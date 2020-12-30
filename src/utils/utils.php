<?php

function fillPageWithError($page, $err)
{
    $page = str_replace('<error-db/>', "", $page);
    foreach($err as $k => $errors){
        $msg = "<ul class='errors-list'>";
        foreach($errors as $error){
            $msg .= "<li> $error </li>";
        }
        $msg .= "</ul>";
        $page = str_replace("<error-$k/>", $msg, $page);
    }
}
