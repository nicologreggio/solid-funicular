<?php
session_start();

require_once(__DIR__."/../helpers/validator.php");
require_once(__DIR__."/utils/utils.php");
require_once(__DIR__."/php/quote/quote.service.php");
require_once(__DIR__."/php/product/product.service.php");

function fillPagewithCartProducts($page)
{
    $listProducts = "";

    foreach($_SESSION['cart'] as $id => $quantity)
    {
        $product = ProductService::getProductDetails((int) $id);

        if($product)
        {
            $listProducts .= "<div class='quote-product'>";

            $listProducts .= "<img src='{$product->getMainImage()}' alt='{$product->getMainImageDescription()}' />";
            $listProducts .= "
                <div class='product-quantity'>
                    <p>Quantità:</p>
                    <b>{$quantity}</b>
                </div>";
            $listProducts .= "<b>{$product->getName()}</b><br />";
            $listProducts .= "<b>Categoria: </b><span>{$product->getCategory()}</span></br/>";

            $listProducts .= "</div>";
        }
    }

    $page = str_replace("<listProducts/>", $listProducts, $page);

    return $page;
}

function cleanPage($page)
{
    $page = str_replace("<value-company/>", "", $page);
    $page = str_replace("<value-telephone/>", "", $page);
    $page = str_replace("<value-reason/>", "", $page);

    $page = str_replace("<error-company/>", "", $page);
    $page = str_replace("<error-telephone/>", "", $page);

    return $page;
}


function validateQuoteData(string $company, string $telephone)
{
    $err = validate([
        'company' => $company,
        'telephone' => $telephone
    ], [
        'company' => ['required'],
        'telephone' => ['required', 'integer']
    ], [
        'company.required' => "Il nome dell'azienda è obbligatorio",
        
        'telephone.required' => "Il numero di telefono è obbligatorio",
        'telephone.integer' => "Il numero di telefono deve essere composto solo da numeri"
    ]);
    
    return $err;
}

function fillPageWithErrorsAndValues($page, $err)
{
    $page = str_replace("<value-company/>", $_POST['company'], $page);
    $page = str_replace("<value-telephone/>", $_POST['telephone'], $page);
    $page = str_replace("<value-reason/>", $_POST['reason'], $page);

    if($err === true)
    {
        $page = str_replace('<error-email/>', "", $page);
        $page = str_replace('<error-password/>', "", $page);
    } else if(is_array($err))
    {
        $page = fillPageWithError($page, $err);
    }

    return $page;
}



if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $company = $_POST['company'];
    $telephone = $_POST['telephone'];
    $reason = $_POST['reason'];
    $user = $_SESSION['user'];

    $err = validateQuoteData($company, $telephone);

    if($err === true)
    {
        QuoteService::addQuotation($company, $telephone, $reason, $_SESSION['user'], $_SESSION['cart']);
        $page = file_get_contents("./cart/thank-you-page.html");
        $page = fetchAndFillCategories($page);
        echo $page;
    }
    else
    {
        $page=fillPagewithCartProducts(file_get_contents("./cart/cart.html"));
        $page=fetchAndFillCategories($page);
        echo fillPageWithErrorsAndValues($page, $err);
    }
}
else
{
    if(isset($_SESSION['user']))
    {
        if(!empty($_SESSION['cart']))
        {
            $page=fillPagewithCartProducts(file_get_contents("./cart/cart.html"));
            $page=fetchAndFillCategories($page);
            echo cleanPage($page);
        }
        else
        {
            $page = file_get_contents("./cart/no-products.html");
            $page = fetchAndFillCategories($page);
            echo $page;
        }
    }
    else
    {
        $page = file_get_contents("./cart/go-to-login-page.html");
        $page = fetchAndFillCategories($page);
        echo $page;
    }
}
