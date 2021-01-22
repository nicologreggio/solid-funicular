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
        $msg = ""; //"<ul class='errors-list'>";
    
        
        foreach($errors as $error)
        {
            $msg .= "{$error}</br>";
        }

        // $msg .= "</ul>";
        $page = str_replace("<error-$k/>", $msg, $page);
    }

    return $page;
}

function base()
{
    return str_replace(PHP_EOL, '', file_get_contents(__DIR__.'/../../.base_path') ?? "");
}

function fillHeader($page, $currentCat=-1)
{
    $categories=CategoryService::getAll();
    $idx=0;

    $header=file_get_contents('./utils/header.html');
    $page=str_replace('<header-navigation />', $header, $page);
    if(isset($_SESSION['user'])){
        $page=str_replace('<account-icon />', '<a href="./logout.php" aria-label="Scollegati dal tuo account">
                <img src="../images/icons/logout.svg" alt="Icona di uscita per effetturare il logout" />
                <span>' . $_SESSION['username'] . '</span>
            </a>', $page);
    }
    else{
        if(!strpos($_SERVER['REQUEST_URI'], 'signup.php') && !strpos($_SERVER['REQUEST_URI'], 'login.php')){
            $page=str_replace('<account-icon />', '<a href="./login.php" aria-label="Esegui l\'accesso">
                    <img src="../images/icons/login.svg" alt="Icona utente per effettuare login" />
                    <span>Accedi</span>
                </a>', $page);
        }
        else{
            $page=str_replace('<account-icon />', '', $page);
        }
    }
        
    foreach($categories as $cat){
        if($cat->getId() == $currentCat){
            $link='<li role="tab" aria-selected="true" class="current" aria-label="Pagina attuale della categoria '.$cat->getName().'">' . $cat->getName() . '</li>';
            $page=str_replace("<cat-name />", $cat->getName(), $page);
            $page=str_replace("<breadcrumbs-location />", $cat->getName(), $page);
        }
        else{
            $link='<li role="tab" aria-selected="false" aria-label="Vai alla pagina della categoria '.$cat->getName().'"><a href="categories.php?cat=' . $cat->getId() . '">' . $cat->getName() . '</a></li>';
        }
        $page=str_replace(("<cat-" . ($idx++) . "/>"), $link, $page);
    }

    return $page;
}

function fillProducts($page, $products){
    $productsList='<ul id="products-list">';

    foreach($products as $product){
        $productsList .= "
            <li class='category-product'>
                <a href='./product-details-page.php?cat={$product->getCategoryId()}&amp;id={$product->getId()}'>
                    <img src='{$product->getMainImage()}' alt='{$product->getMainImageDescription()}' />
                    <p aria-label='Vai alla pagina del prodotto'>{$product->getName()}</p>
                </a>
            </li>";
    }

    $productsList .= '</ul>';

    $page = str_replace('<productsList/>', $productsList, $page);

    return $page;
}

function fillPagination($page, $count, $currentPage)
{
    global $limit;
    
    $paginationStr = '';
    
    $numberPages = floor($count / $limit) + ($count % $limit == 0 ? 0 : 1);
    
    if($numberPages != 1 & $numberPages != 0)
    {
        $paginationStr .= "
            <fieldset id='pagination'>
            <legend>Pagine:&nbsp;</legend>
        ";

        for($i = 1; $i <= $numberPages; ++$i)
        {
            if($currentPage == $i)
            {
                $paginationStr .= "
                    <button 
                        class='button current'
                        name='page'
                        aria-selected='true'
                        value='{$i}'
                        aria-label='Sei alla pagina numero {$i}'
                        disabled='disabled'>
                        {$i}
                    </button>
                ";                
            }
            else
            {
                $paginationStr .= "
                    <button
                        class='button'
                        name='page'
                        aria-selected='false'
                        aria-label='Vai alla pagina numero {$i}'
                        value='{$i}'>
                        {$i}
                    </button>";
            }
        }
        
        $paginationStr .= "</fieldset>";
    }

    $page = str_replace("<pagination/>", $paginationStr, $page);

    return $page;
}
