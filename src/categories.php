<?php

require_once './utils.php';

$category=$_GET['cat'];
$page=file_get_contents('./categories.html');

$page=fetchAndFillCategories($page, $category);

$page=fetchAndFillProducts($page, $category);

echo $page;

?>