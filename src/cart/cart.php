<?php
session_start();

require_once(__DIR__."/../../helpers/validator.php");
require_once(__DIR__."/../utils/utils.php");
require_once(__DIR__."/../php/product/product.service.php");

function fillPagewithCartProducts($page)
{
    if(!empty($_SESSION['cart']))
    {
        $listProducts = "<div id='list-quote-products'><h2>Riepilogo preventivo</h2>";

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
        
        $listProducts .= "</div>";

        $formQuote = "
            <form action='./cart.php' method='POST' data-validate='1'>
                <h2>Form di richiesta preventivo</h2>
                <fieldset>
                    <label for='company'>Azienda*:</label><br />
                    <input
                        id='company'
                        name='company'
                        value='<value-company/>'
                        required='required'
                        data-error-field='error-company' 
						data-rules='required'
						data-error-message=\"Il nome dell'azienda è obbligatorio\"
                        />
					<div id='error-company' class='error'><error-company/></div>

                    <label for='telephone'>Telefono*:</label><br />
                    <input
                        id='telephone'
                        name='telephone'
                        value='<value-telephone/>'
                        required='required'
                        data-error-field='error-telephone'
						data-rules='required|integer'
						data-error-message='Il numero di telefono è obbligatorio e deve essere composto solo da numeri'
                        />
					<div id='error-telephone' class='error'><error-telephone/></div>

                    <label for='reason'>Ragione della richiesta del preventivo:</label><br />
                    <textarea
                        id='reason'
                        name='reason'><value-reason/></textarea>
				</fieldset>
				<div class='buttons-control'>
					<button class='button' type='submit'>Richiedi preventivo</button>
				</div>
			</form>
        ";

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
    $err = validateQuoteData($_POST['company'], $_POST['telephone']);

    var_dump($err);

    if($err === false)
    {
        // echo $_POST['company'].$_POST['telephone'].$_POST['reason'];

        var_dump($_SESSION['user']);
    }
    else
    {
        echo fillPageWithErrorsAndValues(fillPagewithCartProducts(file_get_contents("./cart.html")), $err);
    }
}
else
{
    echo cleanPage(fillPagewithCartProducts(file_get_contents("./cart.html")));
}
