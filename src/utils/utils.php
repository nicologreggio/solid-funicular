<?php

require_once(__DIR__.'/../php/product/product.service.php');
require_once(__DIR__.'/../php/category/category.service.php');

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

function fetchAndFillProducts($page, $category){
    //fetch $category from db

    /* $products=[
        ["../images/products/5feb1efc3d06f.jpeg", "name 1", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 2", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 3", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 4", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 5", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 6", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 7", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 8", ]
    ]; */

    $page=str_replace("<category-description />", CategoryService::getOne($category)->getDescription(), $page);
    $products=ProductService::getProductsWhereCategory($category, 1);
    //$products[]=new ProductModel(1, "cavallo", "un cavallo è un vettore", "noh", "", 8, "../images/products/5feb1efc3d06f.jpeg", "panca", "cat");

    $productsList='<ul id="products-list">';

    foreach($products as $product){
        $productsList .= '<li class="category-product">' . '<a href="./product-details-page.php?id=' . $product->getId() . '"><img src="' . $product->getMainImage() . '" />' . '<p>' . $product->getName() . '</p></a></li>';
    }

    
    
    /* for($i=0; $i<count($products); $i++){
        $productsList .= '<li class="category-product">' . '<a href="products.php?id="' . $i . '><img src="' . $products[$i][0] . '" />' . '<p>' . $products[$i][1] . '</p></a></li>';
    } */

    $productsList .= '</ul>';

    $page=str_replace('<productsList />', $productsList, $page);

    return $page;
}

