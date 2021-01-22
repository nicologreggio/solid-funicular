<?php

require_once './utils/utils.php';

$page=file_get_contents('./contacts/contacts.html');

$page=fillHeader($page);

$countReplace = 2;
$page=str_replace(
    '<li role="tab" aria-selected="false" aria-label="Vai alla pagina dei contatti"><a href="contacts.php">Contatti</a></li>',
    '<li role="tab" aria-selected="true" aria-label="Pagina attuale dei contatti" class="current">Contatti</li>',
    $page, $countReplace
);

$page=str_replace('<breadcrumbs-location />', 'Contatti', $page);

echo $page;