<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = file_get_contents('../template_html/product/index.html');
$products = "";
$cur_page = preg_match('/^[0-9]+$/', $_REQUEST['page']?? '') ? $_REQUEST['page'] : 0;
$per_page = 20;
$stm = DBC::getInstance()->prepare('SELECT * FROM PRODUCTS ORDER BY _ID LIMIT :limit OFFSET :offset');
$stm->bindValue(':limit', (int) $per_page, PDO::PARAM_INT); 
$stm->bindValue(':offset', (int) $cur_page * $per_page, PDO::PARAM_INT); 

foreach(($stm->fetchAll() ?? []) as $prod){
    $products.='
        ...<br>
    ';
}
$sql = "SELECT count(*) FROM PRODUCTS"; 
$number_of_products = DBC::getInstance()->query($sql)->fetchColumn();

$pagination = "";
if($number_of_products > $per_page){
    $last = ceil($number_of_products / $per_page);
    if($cur_page != 0){
        $pagination = '
        <a class="button" title="Vai alla prima pagina" href="/admin/product/index.php?page=0">
            &lt;&lt; Prima
        </a>
        <a class="button" title="Vai alla pagina precedente" href="/admin/product/index.php?page='.($cur_page-1).'">
            &lt; <abbr title="Pagina precedente">Prec.</abbr>
        </a>';
    }
    if($cur_page != $last){
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
