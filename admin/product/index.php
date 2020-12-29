<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = file_get_contents('../template_html/product/index.html');
$products = "";
$cur_page = preg_match('/^[0-9]+$/', $_REQUEST['page']?? '') ? $_REQUEST['page'] : 0;
$per_page = 8;
$stm = DBC::getInstance()->prepare('SELECT * FROM PRODUCTS ORDER BY _ID LIMIT :limit OFFSET :offset');
$stm->bindValue(':limit', (int) $per_page, PDO::PARAM_INT); 
$stm->bindValue(':offset', (int) $cur_page * $per_page, PDO::PARAM_INT); 
$stm->execute();
foreach(($stm->fetchAll() ?? []) as $prod){
    $category_name = DBC::getInstance()->query("SELECT _NAME FROM CATEGORIES WHERE _ID = $prod->_CATEGORY LIMIT 1")->fetchColumn();
    $products.='
        <li>
            <h2 class="strong m0 p0 pt-1 pb-1 img-product">'.e($prod->_NAME).'</h2>
            <img src="'.$prod->_MAIN_IMAGE.'" class="w20 left">
            <div class="w80 right pl-3">
                <h3 class="m0 p0"><abbr title="Identificativo" class="strong">ID:</abbr> '.e($prod->_ID).'</h3>
                <p class="m0 p0 mt-2">
                    <strong>Meta-descrizione: </strong> <br>
                    '.e($prod->_METADESCRIPTION).'
                </p>
                <p class="m0 p0 mt-2">
                    <strong>Descrizione: </strong><br>
                    '.e($prod->_DESCRIPTION).'
                </p>
                <p class="m0 p0 mt-2">
                    <strong>Dimensioni: </strong>
                    '.e($prod->_DIMENSIONS).'
                </p>
                <p class="m0 p0 mt-2">
                    <strong>Età consigliata: </strong>
                    '.e($prod->_AGE).'
                </p>
                <p class="m0 p0 mt-2">
                    <strong>Categoria: </strong> <br>
                    <a href="/admin/category/index.php" title="Visualizza categorie"> '.e($category_name).' </a>
                </p>
            </div>
            <div class="clearfix">
                <a class="w49 left button button-green" href="/admin/product/edit.php?id='.e($prod->_ID).'">Modifica</a>
                <a class="w49 right button button-red" href="/admin/product/delete.php?id='.e($prod->_ID).'">Elimina</a>
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
            &lt;&lt; Prima
        </a>
        <a class="button" title="Vai alla pagina precedente" href="/admin/product/index.php?page='.($cur_page-1).'">
            &lt; <abbr title="Pagina precedente">Prec.</abbr>
        </a>';
    }
    if($cur_page < $last){
        $pagination.= '
        <a class="button" title="Vai alla pagina successiva" href="/admin/product/index.php?page='.($cur_page+1).'">
            <abbr title="Pagina successiva">Succ.</abbr> &gt; 
        </a>
        <a class="button" title="Vai all\'ultima pagina" href="/admin/product/index.php?page='.($last).'">
            Ultima &gt;&gt; 
        </a>';
    }
}

$page = str_replace('<pagination/>', $pagination, $page);
echo str_replace('<products/>', $products, $page);
