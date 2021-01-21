<?php
session_start();

require_once(__DIR__.'/../php/product/product.service.php');
require_once(__DIR__.'/../php/category/category.service.php');

$limit = 9;

function fillPageWithError($page, $err)
{
    $page = str_replace('<error-db/>', "", $page);
    
    foreach($err as $k => $errors)
    {
        $msg = "<ul class='errors-list'>";
    
        
        foreach($errors as $error)
        {
            $msg .= "<li> $error </li>";
        }

        $msg .= "</ul>";
        $page = str_replace("<error-$k/>", $msg, $page);
    }

    return $page;
}

function base()
{
    return str_replace(PHP_EOL, '', file_get_contents(__DIR__.'/../.base_path') ?? "");
}

function fetchAndFillCategories($page, $currentCat=-1)
{
    //do the real db job
    //$categories = ["La Categoria 1", "Categoria num 2", "Terza Categoria", "4 di numero", "L'ultima si, la 5"];
    $categories=CategoryService::getAll();
    $idx=0;
        
    foreach($categories as $cat){
        if($cat->getId() == $currentCat){
            $link='<li id="currentLink">' . $cat->getName() . '</li>';
            $page=str_replace("<cat-name />", $cat->getName(), $page);
        }
        else{
            $link='<li><a href="categories.php?cat=' . $cat->getId() . '">' . $cat->getName() . '</a></li>';
        }
        $page=str_replace(("<cat-" . ($idx++) . "/>"), $link, $page);
    }

    /* foreach ($categories as $idx => $cat) {
        //<a href="categories.php/2"><cat-2/></a>
        //TODO substitute with id from categ
        if($idx == $currentCat){
            $link='<li id="currentLink">' . $cat . '</li>';
            $page=str_replace("<cat-name />", $cat, $page);
        }
        else{
            $link='<li><a href="categories.php?cat=' . $idx . '">' . $cat . '</a></li>';
        }
        $page=str_replace(("<cat-" . $idx . "/>"), $link, $page);
        //echo "<cat-" . ($idx+1) . "/>";
    } */

    return $page;
}

function fillProducts($page, $products){
    $productsList='<ul id="products-list">';

    foreach($products as $product){
        $productsList .= "
            <li class='category-product'>
                <a href='./product-details-page.php?id={$product->getId()}'>
                    <img src='{$product->getMainImage()}' alt='{$product->getMainImageDescription()}' />
                    <p>{$product->getName()}</p>
                </a>
            </li>";
    }

    $productsList .= '</ul>';

    $page = str_replace('<productsList/>', $productsList, $page);

    return $page;
}

function fillPagination($page, $count)
{
    global $limit;
    
    $paginationStr = '';
    
    $numberPages = floor($count / $limit) + ($count % $limit == 0 ? 0 : 1);
    
    if($numberPages != 1)
    {
        $paginationStr .= "
            <fieldset id='pagination'>
        ";

        for($i = 1; $i <= $numberPages; ++$i)
        {
            $paginationStr .= "<button class='pages' name='page' value='{$i}'>{$i}</button>";
        }
        
        $paginationStr .= "</fieldset>";
    }

    $page = str_replace("<pagination/>", $paginationStr, $page);

    return $page;
}
