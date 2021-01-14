<?php
session_start();

require_once(__DIR__."/../php/product/product.service.php");

function fillPagewithCartProducts($page)
{
    if(!empty($_SESSION['cart']))
    {
        $listProducts = "<div id='list-quote-products'>";

        foreach($_SESSION['cart'] as $id => $quantity)
        {
            $product = ProductService::getProductDetails($id);

            $listProducts .= "<div class='quote-product'>";

            $listProducts .= "<img src='{$product->getMainImage()}' alt='{$product->getMainImageDescription()}' />";
            $listProducts .= "<b>{$product->getName()}</b><br />";
            $listProducts .= "<b>Categoria: </b><span>{$product->getCategory()}</span></br/>";
            $listProducts .= "
                <div class='product-quantity'>
                    <p>Quantità:</p>
                    <b>{$quantity}</b>
                </div>";

            $listProducts .= "</div>";
        }
        
        $listProducts .= "</div>";

        $formQuote = "";

        $page = str_replace("<noProducts/>", "", $page);
        $page = str_replace("<listProducts/>", $listProducts, $page);
        $page = str_replace("<formQuote/>", $formQuote, $page);
    }
    else
    {
        $noProducts = "No products";
        $page = str_replace("<noProducts/>", $noProducts, $page);
        $page = str_replace("<listProducts/>", "", $page);
        $page = str_replace("<formQuote/>", "", $page);
    }

    return $page;
}

echo fillPagewithCartProducts(file_get_contents("./cart.html"));
