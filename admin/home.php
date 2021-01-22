<?php
require_once(__DIR__.'/inc/header_php.php');
redirectIfNotLogged();
echo str_replace('<username/>', auth()->user()->_NAME, file_get_contents('template_html/home.html'));
