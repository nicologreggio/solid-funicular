<?php

require_once(__DIR__."/../php/product/product.service.php");

function fillPageWithDetails(string $page, ProductModel $product)
{
    $page = str_replace("<productName/>", $product->getName(), $page);
    $page = str_replace("<productDescription/>", $product->getDescription(), $page);
    $page = str_replace("<productDimensions/>", $product->getDimensions(), $page);
    $page = str_replace("<productAge/>", $product->getAge(), $page);
    $page = str_replace("<productMainImage/>", $product->getMainImage(), $page);
    $page = str_replace("<productMainImageDescription/>", $product->getMainImageDescription(), $page);
    $page = str_replace("<productCategory/>", $product->getCategory(), $page);
    // TODO Materials

    return $page;
}

$product = ProductService::getProductDetails($_GET['id']);

if($product)
{
    echo fillPageWithDetails(file_get_contents('./product-details-page.html'), $product);
}
else
{
    echo "Page error";
}
