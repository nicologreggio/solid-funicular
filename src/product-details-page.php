<?php
session_start();

require_once(__DIR__."/php/product/product.service.php");
require_once(__DIR__."/utils/utils.php");

function fillPageWithDetails(string $page, ProductModel $product)
{
    $cat=$_GET['cat'];
    $catLink='<a href="categories.php?cat=' . $cat . '">' . $product->getCategory() . '</a>';
    $page=str_replace("<cat-link />", $catLink, $page);
    //$page=str_replace("<product-")
    
    $page = str_replace("<productName/>", $product->getName(), $page);
    $page = str_replace("<productDescription/>", $product->getMetaDescription(), $page);

    $dimensions = $product->getDimensions();
    $dimensionsStr = $dimensions ? "
        <li>
            <strong>Dimensione:</strong>
            <span class='product-detail'>{$dimensions}</span><br />
        </li>
    " : "";
    $page = str_replace("<productDimensions/>", $dimensionsStr, $page);

    $age = $product->getAge();
    $ageStr = $age ? "
        <li>
            <strong>Età indicata:</strong>
            <span class='product-detail'>{$age}</span><br />
        </li>
    " : "";
    $page = str_replace("<productAge/>", $ageStr, $page);
    
    $page = str_replace("<productMainImage/>", $product->getMainImage(), $page);
    $page = str_replace("<productMainImageDescription/>", $product->getMainImageDescription(), $page);
    $page = str_replace("<productCategory/>", $product->getCategory(), $page);

    if($_SESSION['cart'][$product->getId()])
    {
        $removeForm = "<form class='form-quotation' method='POST' action='./php/remove-from-cart-quotation.php'><button type='submit'>Rimuovi il prodotto</button></form>";
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
    
    if(!empty($materials))
    {
        $productMaterials .= '
            <li>
                <strong>Materiali:</strong>
                <span class="product-materials">
        ';


        foreach($materials as $index => $material)
        {
            $productMaterials .= "{$material->getName()}";

            if(($index + 1) != count($materials))
            {
                $productMaterials .= ", ";
            }
        }

        $productMaterials .= "</span></li>";
    }

    $page = str_replace("<productMaterials/>", $productMaterials, $page);

    return $page;
}



if($id = $_GET['id'])
{
    $product = ProductService::getProductDetails($id);
    
    if($product)
    {
        $_SESSION['actual-product-id'] = $id;
        $page=file_get_contents('./product-details-page/product-details-page.html');
        $page=str_replace("<cat-name />", $product->getName() . ' | ' . $product->getCategory(), $page);
        $page=fetchAndFillCategories($page);
        $page=fillPageWithDetails($page, $product);
        echo $page;
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


