<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/product/index.html');

$cur_page = preg_match('/^[0-9]+$/', $_REQUEST['page']?? '') ? $_REQUEST['page'] : 0;
$per_page = 8;
$stm = DBC::getInstance()->prepare('SELECT * FROM PRODUCTS ORDER BY _ID LIMIT :limit OFFSET :offset');
$stm->bindValue(':limit', (int) $per_page, PDO::PARAM_INT); 
$stm->bindValue(':offset', (int) $cur_page * $per_page, PDO::PARAM_INT); 
$stm->execute();

$products = "";
foreach(($stm->fetchAll() ?? []) as $prod){
    $category_name = DBC::getInstance()->query("SELECT _NAME FROM CATEGORIES WHERE _ID = $prod->_CATEGORY LIMIT 1")->fetchColumn();
    $product_materials = DBC::getInstance()->query("
        SELECT *
        FROM MATERIALS JOIN PRODUCT_MATERIAL WHERE _ID = _MATERIAL_ID AND _PRODUCT_ID = $prod->_ID
    ")->fetchAll() ?? [];
    if(empty($product_materials)){
        $materials = '<p class="m0 p0 mt-2 strong">Nessun materiale associato a questo prodotto></p>';
    }
    else {
        $materials = '
        <div class="m0 p0 mt-2">
            <p class="strong">Materiali: </p>
            <ul class="pl-2">' ;
        foreach($product_materials as $mat){
            $materials.="<li>".e($mat->_NAME)."</li>";
        }
        $materials.="
            </ul>
        </div>";
    }
    
    $products.='
        <li>
            <h2 class="strong m0 p0 pt-1 pb-1 img-product">'.e($prod->_NAME).'</h2>
            <img src="'.$prod->_MAIN_IMAGE.'" class="w20 w100-sm left" alt="'.$prod->_MAIN_IMAGE_DESCRIPTION.'">
            <div class="w80 w100-sm right pl-3 pl-0-sm pt-2-sm">
                <h3 class="m0 p0"><abbr title="Identificativo" class="strong">ID:</abbr> '.e($prod->_ID).'</h3>
                <p class="m0 p0 mt-2 strong">
                    Meta-descrizione:
                </p>
                <p class="m0 p0">
                    '.e($prod->_METADESCRIPTION).'
                </p>
                <p class="m0 p0 mt-2 strong">
                    Descrizione:
                </p>
                <p class="m0 p0">
                    '.e($prod->_DESCRIPTION).'
                </p>';
    if($prod->_DIMENSIONS) $products.=
                '<p class="m0 p0 mt-2">
                    <span class="strong">Dimensioni: </span>
                    '.e($prod->_DIMENSIONS).'
                </p>';
    if($prod->_AGE) $products.=
                '<p class="m0 p0 mt-2">
                    <span class="strong">Età consigliata: </span>
                    '.e($prod->_AGE).'
                </p>';
    $products.=
                '<p class="m0 p0 mt-2 strong">
                    Categoria: 
                </p>
                <a href="../category/index.php" title="Visualizza categorie"> '.e($category_name).' </a>
                '.$materials.'
            </div>
            <div class="clearfix">
                <a class="w49 left button button-green" title="Modifica il prodotto: '.e($prod->_NAME).'" href="edit.php?id='.e($prod->_ID).'&amp;page='.e($_REQUEST['page'] ?? 0).'">Modifica</a>
                <a class="w49 right button button-red"  title="Elimina il prodotto: '.e($prod->_NAME).'" href="delete.php?id='.e($prod->_ID).'">Elimina</a>
            </div>
            <hr class="mt-3">
        </li>
    ';
}
$page = str_replace('<products/>', $products, $page);



pagination($page, $per_page, $cur_page, "product",  DBC::getInstance()->query(
    "SELECT count(*) FROM PRODUCTS"
)->fetchColumn());
echo str_replace('<products/>', $products, $page);
