<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/category/index.html');

$cur_page = preg_match('/^[0-9]+$/', $_REQUEST['page']?? '') ? $_REQUEST['page'] : 0;
$per_page = 4;

$stm = DBC::getInstance()->prepare('SELECT * FROM CATEGORIES ORDER BY _ID DESC LIMIT :limit OFFSET :offset');
$stm->bindValue(':limit', (int) $per_page, PDO::PARAM_INT); 
$stm->bindValue(':offset', (int) $cur_page * $per_page, PDO::PARAM_INT); 
$stm->execute();

$categories = "";
foreach($stm->fetchAll() as $cat){ 
    $categories.='
    <li id="category-'.e($cat->_ID).'">
        <h2 class="strong m0 p0 pt-1 pb-1">'.e($cat->_NAME).'</h2>
        <h3 class="m0 p0"><abbr title="Identificativo" class="strong">ID:</abbr> '.e($cat->_ID).'</h3>
        <p class="m0 p0">La categoria <strong>'.($cat->_MENU ? '': 'NON').' verrà mostrata</strong> nel menu</p>
        <p class="m0 p0 mt-2 ">
            <span class="strong">Meta-descrizione:</span> <br />
            '.e($cat->_METADESCRIPTION).'
        </p>
        <p class="m0 p0 mt-2">
            <span class="strong">Descrizione:</span><br />
            '.$cat->_DESCRIPTION.'
        </p>
        <div class="clearfix">
            <a 
                class="w49 left button button-green" 
                href="edit.php?id='.e($cat->_ID).'&amp;page='.e($_REQUEST['page'] ?? 0).'" 
                title="Modifica la categoria:'.e($cat->_NAME).'">
                    Modifica
            </a>
            <a 
                class="w49 right button button-red" 
                href="delete.php?id='.e($cat->_ID).'" 
                title="Elimina la categoria:'.e($cat->_NAME).'">
                    Elimina
            </a>
        </div>
        <hr class="mt-3" />
    </li>
    ';
}


pagination($page, $per_page, $cur_page, DBC::getInstance()->query(
    "SELECT count(*) FROM CATEGORIES"
)->fetchColumn());

echo str_replace('<categories/>', $categories, $page);
