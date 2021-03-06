<?php
session_start();

require_once(__DIR__."/helpers/validator.php");
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
            $listProducts .= "
                <div class='quote-product'>
                    <img class='quote-product-img' src='{$product->getMainImage()}' alt='{$product->getMainImageDescription()}' />
                    <div class='quote-information'>
                        <p class='bold'>{$product->getName()}</p>
                        <span class='bold'>Categoria: </span><span>{$product->getCategory()}</span>
                    </div>
                    <div class='quote-control'>
                        <div class='product-quantity'>
                            <p>Quantità:</p>
                            <span class='bold'>{$quantity}</span>
                        </div>
                        <form class='remove-product' action='./php/remove-from-cart-quotation.php' method='post' aria-label='Rimuovi il prodotto dal preventivo'>
                            <input type='hidden' name='product-id' value='{$product->getId()}' />
                            <button 
                                class='remove-product-button button'
                                type='submit' aria-label='Rimuovi il prodotto dal preventivo'>
                                <span>Rimuovi</span>
                            </button>
                        </form>
                    </div>
                </div>
            ";
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

    if(is_array($err))
    {
        $page = fillPageWithError($page, $err);
    }

    $page = str_replace('<error-email/>', "", $page);
    $page = str_replace('<error-password/>', "", $page);

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
        $res = QuoteService::addQuotation($company, $telephone, $reason, $_SESSION['user'], $_SESSION['cart']);

        if($res != -1)
        {
            unset($_SESSION['cart']);
            $page = file_get_contents("./cart/thank-you-page.html");
            $page = fillHeader($page);
        }
    }
    else
    {
        $page = fillPagewithCartProducts(file_get_contents("./cart/cart.html"));
        $page = fillHeader($page);
        $page = fillPageWithErrorsAndValues($page, $err);
    }
}
else
{
    if(isset($_SESSION['user']))
    {
        if(!empty($_SESSION['cart']))
        {
            $page=fillPagewithCartProducts(file_get_contents("./cart/cart.html"));
        }
        else
        {
            $page = file_get_contents("./cart/no-products.html");
        }
    }
    else
    {
        $page = file_get_contents("./cart/go-to-login-page.html");
    }

    $page = fillHeader($page);
    $page = cleanPage($page);
}

$page=str_replace('<breadcrumbs-location />', 'Carrello', $page);
$page=str_replace('<a id="cart-icon" class="icon" href="./cart.php" title="Vai alla pagina del carrello">Carrello</a>', '', $page);

echo $page;
