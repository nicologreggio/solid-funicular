<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/material/index.html');

$cur_page = preg_match('/^[0-9]+$/', $_REQUEST['page']?? '') ? $_REQUEST['page'] : 0;
$per_page = 6;

$stm = DBC::getInstance()->prepare('SELECT * FROM MATERIALS ORDER BY _ID LIMIT :limit OFFSET :offset');
$stm->bindValue(':limit', (int) $per_page, PDO::PARAM_INT); 
$stm->bindValue(':offset', (int) $cur_page * $per_page, PDO::PARAM_INT); 
$stm->execute();

$materials = "";
foreach($stm->fetchAll() as $mat){
    $materials.='
    <li>
        <h2 class="strong m0 p0 pt-1 pb-1">'.e($mat->_NAME).'</h2>
        <h3 class="m0 p0"><abbr title="Identificativo" class="strong">ID:</abbr> '.e($mat->_ID).'</h3>
        <p class="m0 p0 mt-2"> 
            <strong>Descrizione: </strong><br>
            '.e($mat->_DESCRIPTION).'
        </p>

        <div class="clearfix">
            <a class="w49 left button button-green" title="Modifica il materiale:'.e($mat->_NAME).'&page='.e($_REQUEST['page'] ?? 0).'" href="/admin/material/edit.php?id='.e($mat->_ID).'">Modifica</a>
            <a class="w49 right button button-red" title="Elimina il materiale:'.e($mat->_NAME).'" href="/admin/material/delete.php?id='.e($mat->_ID).'">Elimina</a>
        </div>
        <hr class="mt-3">
    </li>
    ';
}


pagination($page, $per_page, $cur_page, "material", DBC::getInstance()->query(
    "SELECT count(*) FROM MATERIALS"
)->fetchColumn());

echo str_replace('<materials/>', $materials, $page);
