<?php
require_once(__DIR__.'/utils/utils.php');

$page = file_get_contents('./categories/allcategories.html');

$page=fillHeader($page); 

$page=fillCategoriesList($page);

$page=str_replace(
    '<li role="tab" aria-selected="false"><a title="Vai alla pagina di tutte le categorie" href="allcategories.php">Tutte le Categorie</a></li>',
    '<li role="tab" aria-selected="true" aria-label="Pagina attuale di tutte le categorie" class="current">Tutte le categorie</li>',
    $page
);

$page=str_replace('<breadcrumbs-location />', 'Categorie', $page);

echo $page;
