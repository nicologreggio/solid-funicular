<?php

require_once './utils/utils.php';

$page=file_get_contents('./contacts/contacts.html');

$page=fillHeader($page);

$page=str_replace('<li><a href="contacts.php">Contatti</a></li>', '<li id="currentLink">Contatti</li>', $page);

$page=str_replace('<breadcrumbs-location />', 'Contatti', $page);

echo $page;