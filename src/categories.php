<?php

require_once(__DIR__.'/utils/utils.php');

$category = (int) $_GET['cat']; 
$page = file_get_contents('./categories/categories.html');

$search = [ 
    "category" => $category,
    "page" => ($_GET['page']) ? (int) ($_GET['page']) : 1
];

$page=fillHeader($page, $category);

$page = str_replace("<categoryDescription/>", CategoryService::getOne($category)->getDescription(), $page);
$page = str_replace("<catId/>", $category, $page);

$products = ProductService::getProductsList($search, $limit);

$page = fillProducts($page, $products);

$count = ProductService::getProductsListCount($search);

$page = fillPagination($page, $count);

echo $page;
