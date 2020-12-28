<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = file_get_contents('../template_html/category/index.html');
$categories = "";
$cur_page = preg_match('/^[0-9]+$/', $_REQUEST['page']?? '') ? $_REQUEST['page'] : 0;
$per_page = 4;

$stm = DBC::getInstance()->prepare('SELECT * FROM CATEGORIES ORDER BY _ID LIMIT :limit OFFSET :offset');
$stm->bindValue(':limit', (int) $per_page, PDO::PARAM_INT); 
$stm->bindValue(':offset', (int) $cur_page * $per_page, PDO::PARAM_INT); 
$stm->execute();
foreach($stm->fetchAll() as $cat){
    $categories.='
    <li>
        <h2 class="strong m0 p0 pt-1 pb-1">'.e($cat->_NAME).'</h2>
        <h3 class="m0 p0"><abbr title="Identificativo" class="strong">ID:</abbr> '.e($cat->_ID).'</h3>
        <p class="m0 p0">La categoria <strong>'.($cat->_MENU ? '': 'NON').'verrà mostrata</strong> nel menu</p>
        <p class="m0 p0 mt-2">
            <strong>Meta-descrizione:</strong> <br>
            '.e($cat->_METADESCRIPTION).'
        </p>
        <p class="m0 p0 mt-2">
            <strong>Descrizione:</strong><br>
            '.$cat->_DESCRIPTION.'
        </p>
        <div class="clearfix">
            <a class="w49 left button button-green" href="/admin/category/edit.php?id='.e($cat->_ID).'">Modifica</a>
            <a class="w49 right button button-red" href="/admin/category/delete.php?id='.e($cat->_ID).'">Elimina</a>
        </div>
        <hr class="mt-3">
    </li>
    ';
}




$sql = "SELECT count(*) FROM CATEGORIES"; 
$number_of_categories = DBC::getInstance()->query($sql)->fetchColumn();

$pagination = "";
if($number_of_categories > $per_page){
    $last = ceil($number_of_categories / $per_page) - 1;
    if($cur_page > 0){
        $pagination = '
        <a class="button" title="Vai alla prima pagina" href="/admin/category/index.php?page=0">
            &lt;&lt; Prima
        </a>
        <a class="button" title="Vai alla pagina precedente" href="/admin/category/index.php?page='.($cur_page-1).'">
            &lt; <abbr title="Pagina precedente">Prec.</abbr>
        </a>';
    }
    if($cur_page < $last){
        $pagination.= '
        <a class="button" title="Vai alla pagina successiva" href="/admin/category/index.php?page='.($cur_page+1).'">
            <abbr title="Pagina successiva">Succ.</abbr> &gt; 
        </a>
        <a class="button" title="Vai all\'ultima pagina" href="/admin/category/index.php?page='.($last).'">
            Ultima &gt;&gt; 
        </a>';
    }
}

$page = str_replace('<pagination/>', $pagination, $page);

echo str_replace('<categories/>', $categories, $page);
