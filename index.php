<?php
require_once(__DIR__.'/utils/utils.php');
require_once(__DIR__.'/inc/header_php.php');

$page=file_get_contents('./index.html');

$page=fillHeader($page); 

$countReplace = 2;
$page=str_replace(
    '<li role="tab" aria-selected="false" xml:lang="en" lang="en"><a title="Vai alla pagina principale" href="index.php">Home</a></li>', 
    '<li role="tab" aria-selected="true" aria-label="Pagina attuale principale" xml:lang="en" lang="en" class="current">Home</li>',
    $page, $countReplace
);

$page=str_replace('<breadcrumbs-location />', '<span xml:lang="en" lang="en">Home</span>', $page);

echo $page;
