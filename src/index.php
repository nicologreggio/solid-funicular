<?php
session_start();

require_once './utils/utils.php';

$page=file_get_contents('./index.html');

$page=fillHeader($page); 

$page=str_replace('<li xml:lang="en"><a href="index.php">Home</a></li>', '<li xml:lang="en" id="currentLink">Home</li>', $page);

$page=str_replace('<breadcrumbs-location />', '<span xml:lang="en">Home</span>', $page);

echo $page;

?>