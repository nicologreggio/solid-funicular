<?php
session_start();

require_once './utils/utils.php';

$page=file_get_contents('./index.html');

$page=fillHeader($page); 

$countReplace = 2;
$page=str_replace(
    '<li role="tab" aria-selected="false" aria-label="Vai alla pagina principale" xml:lang="en"><a href="index.php">Home</a></li>', 
    '<li role="tab" aria-selected="true" aria-label="Pagina attuale principale" xml:lang="en" class="current">Home</li>',
    $page, $countReplace
);

$page=str_replace('<breadcrumbs-location />', '<span xml:lang="en">Home</span>', $page);

echo $page;
