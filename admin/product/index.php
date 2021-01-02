<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/product/index.html');
$page = str_replace('<page/>', ($_REQUEST['page'] ?? 0) + 1, $page);
$products = "";
$cur_page = preg_match('/^[0-9]+$/', $_REQUEST['page']?? '') ? $_REQUEST['page'] : 0;
$per_page = 8;
$stm = DBC::getInstance()->prepare('SELECT * FROM PRODUCTS ORDER BY _ID LIMIT :limit OFFSET :offset');
$stm->bindValue(':limit', (int) $per_page, PDO::PARAM_INT); 
$stm->bindValue(':offset', (int) $cur_page * $per_page, PDO::PARAM_INT); 
$stm->execute();
foreach(($stm->fetchAll() ?? []) as $prod){
    $category_name = DBC::getInstance()->query("SELECT _NAME FROM CATEGORIES WHERE _ID = $prod->_CATEGORY LIMIT 1")->fetchColumn();
    $product_materials = DBC::getInstance()->query("
        SELECT *
        FROM MATERIALS JOIN PRODUCT_MATERIAL WHERE _ID = _MATERIAL_ID AND _PRODUCT_ID = $prod->_ID
    ")->fetchAll() ?? [];
    if(empty($product_materials)){
        $materials = '<p class="m0 p0 mt-2"><strong>Nessun materiale associato a questo prodotto</strong></p>';
    }
    else {
        $materials = '
        <p class="m0 p0 mt-2">
            <strong>Materiali: </strong>
            <ul class="pl-2">' ;
        foreach($product_materials as $mat){
            $materials.="<li>".e($mat->_NAME)."</li>";
        }
        $materials.="
            </ul>
        </p>";
    }
    
    $products.='
        <li>
            <h2 class="strong m0 p0 pt-1 pb-1 img-product">'.e($prod->_NAME).'</h2>
            <img src="'.$prod->_MAIN_IMAGE.'" class="w20 w100-sm left" alt="'.$prod->_MAIN_IMAGE_DESCRIPTION.'">
            <div class="w80 w100-sm right pl-3 pl-0-sm pt-2-sm">
                <h3 class="m0 p0"><abbr title="Identificativo" class="strong">ID:</abbr> '.e($prod->_ID).'</h3>
                <p class="m0 p0 mt-2">
                    <strong>Meta-descrizione: </strong> <br>
                    '.e($prod->_METADESCRIPTION).'
                </p>
                <p class="m0 p0 mt-2">
                    <strong>Descrizione: </strong><br>
                    '.e($prod->_DESCRIPTION).'
                </p>';
    if($prod->_DIMENSIONS) $products.=
                '<p class="m0 p0 mt-2">
                    <strong>Dimensioni: </strong>
                    '.e($prod->_DIMENSIONS).'
                </p>';
    if($prod->_AGE) $products.=
                '<p class="m0 p0 mt-2">
                    <strong>Età consigliata: </strong>
                    '.e($prod->_AGE).'
                </p>';
    $products.=
                '<p class="m0 p0 mt-2">
                    <strong>Categoria: </strong> <br>
                    <a href="/admin/category/index.php" title="Visualizza categorie"> '.e($category_name).' </a>
                </p>
                '.$materials.'
            </div>
            <div class="clearfix">
                <a class="w49 left button button-green" title="Modifica il prodotto: '.e($prod->_NAME).'" href="/admin/product/edit.php?id='.e($prod->_ID).'&page='.e($_REQUEST['page'] ?? 0).'">Modifica</a>
                <a class="w49 right button button-red"  title="Elimina il prodotto: '.e($prod->_NAME).'" href="/admin/product/delete.php?id='.e($prod->_ID).'">Elimina</a>
            </div>
            <hr class="mt-3">
        </li>
    ';
}
$page = str_replace('<products/>', $products, $page);



$sql = "SELECT count(*) FROM PRODUCTS"; 
$number_of_products = DBC::getInstance()->query($sql)->fetchColumn();

$pagination = "";
if($number_of_products > $per_page){
    $last = ceil($number_of_products / $per_page) - 1;
    if($cur_page > 0){
        $pagination = '
        <a class="button" title="Vai alla prima pagina" href="/admin/product/index.php?page=0">
            &lt;&lt; <span>Prima</span>
        </a>
        <a class="button" title="Vai alla pagina precedente" href="/admin/product/index.php?page='.($cur_page-1).'">
            &lt; <span><abbr title="Pagina precedente">Prec.</abbr></span>
        </a>';
    }
    if($cur_page < $last){
        $pagination.= '
        <a class="button" title="Vai alla pagina successiva" href="/admin/product/index.php?page='.($cur_page+1).'">
            <span><abbr title="Pagina successiva">Succ.</abbr></span> &gt; 
        </a>
        <a class="button" title="Vai all\'ultima pagina" href="/admin/product/index.php?page='.($last).'">
            <span>Ultima</span> &gt;&gt; 
        </a>';
    }
}

$page = str_replace('<pagination/>', $pagination, $page);
echo str_replace('<products/>', $products, $page);
