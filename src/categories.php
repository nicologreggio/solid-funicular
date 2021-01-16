<?php

require_once(__DIR__.'/utils/utils.php');

$category=$_GET['cat']; 
$page=file_get_contents('./categories/categories.html');

$page=fetchAndFillCategories($page, $category);

$page=fetchAndFillProducts($page, $category);

echo $page;

?>