<?php
session_start();

require_once(__DIR__."/utils/utils.php");
require_once(__DIR__."/php/category/category.service.php");
require_once(__DIR__."/php/material/material.service.php");
require_once(__DIR__."/php/product/product.service.php");

function fillSearchbar($page)
{
    $searchbarStr = "
        <label for='searchbar'>Termini di ricerca</label>
        <input 
            id='searchbar'
            type='text'
            placeholder='Inserisci i termini di ricerca'
            aria-label='Inserisci i termini di ricerca'
            name='searchbar'
            inputmode='search'
            value='{$_SESSION['search']['name']}'
        />
    ";

    $page = str_replace("<searchbar/>", $searchbarStr, $page);

    return $page;
}

function fillCategories($page)
{
    $categoriesStr = "
        <label for='categories'>Categoria</label>
        <select id='categories' name='category' aria-label='Inserisci la categoria per cui ricercare'>
            <option value=''>Tutte le categorie</option>
    ";

    $categories = CategoryService::getAll();

    foreach($categories as $category)
    {
        $categoriesStr .= "<option value='{$category->getId()}' ";

        if($category->getId() == $_SESSION['search']['category'])
        {
            $categoriesStr .= "selected='selected'";
        }

        $categoriesStr .= ">{$category->getName()}</option>";
    }

    $categoriesStr .= "</select>";

    $page = str_replace("<categories/>", $categoriesStr, $page);

    return $page;
}

function fillMaterials($page)
{
    $materialsStr="";

    $materials = MaterialService::getAll();

    $searchedMaterials = $_SESSION['search']['materials'];

    foreach($materials as $index => $material)
    {
        $materialsStr .= "
            <p class='search-material'>
                <input
                    id='search-material-{$index}'
                    type='checkbox'
                    name='materials[]'
                    value='{$material->getId()}' 
            ";

        if($searchedMaterials)
        {
            if(in_array($material->getId(), $searchedMaterials))
            {
                $materialsStr .= "checked='checked'";
            }
        }
        
        $materialsStr .= "/><label for='search-material-{$index}'>{$material->getName()}</label></p>";
    }

    $page = str_replace("<materials/>", $materialsStr, $page);

    return $page;
}

function fillProductsList($page)
{
    global $limit;
    $products = ProductService::getProductsList($_SESSION['search'], $limit);

    if(count($products) == 0)
    {
        $productsStr = "No products";
        $page = str_replace("<products-list/>", $productsStr, $page);
    }
    else
    {
        $page = fillProducts($page, $products);
    }

    return $page;
}

function fillPage($page)
{
    $page = fillSearchbar($page);
    $page = fillCategories($page);
    $page = fillMaterials($page);
    $page = fillProductsList($page);

    $count = ProductService::getProductsListCount($_SESSION['search']);

    $page = fillPagination($page, $count, $_SESSION['search']['page']);

    return $page;
}

$_SESSION['search'] = [
    'name' => $_GET['searchbar'],
    'category' => (int) $_GET['category'],
    'materials' => $_GET['materials'],
    'page' => ($_GET['page']) ? (int) ($_GET['page']) : 1
];

$page = file_get_contents("./search/search.html");
$page = fillHeader($page);
$page = str_replace('<breadcrumbs-location />', 'Ricerca', $page);
$page = str_replace('<a id="search-icon" class="icon" href="./search.php" title="Vai alla pagina di ricerca">Cerca</a>', '', $page);

$page=fillPage($page);

echo $page;
