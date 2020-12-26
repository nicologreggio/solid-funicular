<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = file_get_contents('../template_html/category/index.html');
echo $page;
