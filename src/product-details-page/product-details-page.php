<?php
session_start();

require_once(__DIR__."/../php/product/product.service.php");

function fillPageWithDetails(string $page, ProductModel $product)
{
    // $page = str_replace("<productId/>", $product->getId(), $page);
    $page = str_replace("<productName/>", $product->getName(), $page);
    $page = str_replace("<productDescription/>", $product->getDescription(), $page);
    $page = str_replace("<productDimensions/>", $product->getDimensions(), $page);
    $page = str_replace("<productAge/>", $product->getAge(), $page);
    $page = str_replace("<productMainImage/>", $product->getMainImage(), $page);
    $page = str_replace("<productMainImageDescription/>", $product->getMainImageDescription(), $page);
    $page = str_replace("<productCategory/>", $product->getCategory(), $page);

    if($_SESSION['cart'][$product->getId()])
    {
        $removeForm = "<form class='form-quotation' method='POST' action='../php/remove-from-cart-quotation.php'><button type='submit'>Rimuovi il prodotto</button></form>";
        $quantity = $_SESSION['cart'][$product->getId()];
        $addOrUpdateString = "Modifica la quantità";
    }
    else
    {
        $removeForm = "";
        $quantity = 1;
        $addOrUpdateString = "Aggiungi al preventivo";
    }

    $page = str_replace("<removeProductForm/>", $removeForm, $page);
    $page = str_replace("<productQuantity/>", $quantity, $page);
    $page = str_replace("<addOrUpdateToQuote/>", $addOrUpdateString, $page);

    $productMaterials = '';

    $materials = $product->getMaterials();

    foreach($materials as $index => $material)
    {
        $productMaterials .= "{$material->getName()}";

        if(($index + 1) != count($materials))
        {
            $productMaterials .= ", ";
        }
    }

    $page = str_replace("<productMaterials/>", $productMaterials, $page);

    return $page;
}



if($id = $_GET['id'])
{
    $product = ProductService::getProductDetails($id);
    
    if($product)
    {
        echo fillPageWithDetails(file_get_contents('./product-details-page.html'), $product);
    }
    else
    {
        echo "Page error";
    }
}
else
{
    echo "Inserire id"; 
}


