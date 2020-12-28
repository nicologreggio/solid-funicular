<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = file_get_contents('../template_html/category/index.html');
$categories = "";
foreach(DBC::getInstance()->query('SELECT * FROM CATEGORIES')->fetchAll() as $cat){
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
            '.e($cat->_DESCRIPTION).'
        </p>
        <div class="clearfix">
            <a class="w49 left button button-green" href="/admin/category/edit.php?id='.e($cat->_ID).'">Modifica</a>
            <a class="w49 right button button-red" href="/admin/category/delete.php?id='.e($cat->_ID).'">Elimina</a>
        </div>
        <hr class="mt-3">
    </li>
    ';
}
echo str_replace('<categories/>', $categories, $page);
