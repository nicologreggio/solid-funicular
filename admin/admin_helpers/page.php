<?php
function page($path){
    $page = file_get_contents($path);
    $page = str_replace('<page/>', ($_REQUEST['page'] ?? 0) + 1, $page);
    return str_replace('<message/>', message(), $page);
}