<?php

require_once(__DIR__.'/utils/utils.php');

$category = (int) $_GET['cat']; 
$currentPage = ($_GET['page']) ? (int) ($_GET['page']) : 1;
$page = file_get_contents('./categories/categories.html');

echo $currentPage;

$search = [ 
    "category" => $category,
    "page" => $currentPage
];

$page=fillHeader($page, $category);

$page = str_replace("<categoryDescription/>", CategoryService::getOne($category)->getDescription(), $page);
$page = str_replace("<catId/>", $category, $page);

$products = ProductService::getProductsList($search, $limit);

$page = fillProducts($page, $products);

$count = ProductService::getProductsListCount($search);

$page = fillPagination($page, $count, $currentPage);

echo $page;
