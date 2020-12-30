<?php
function page($path){
    $page = file_get_contents($path);
    return str_replace('<message/>', message(), $page);
}