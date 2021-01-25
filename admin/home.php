<?php
require_once(__DIR__.'/inc/header_php.php');
redirectIfNotLogged();
echo str_replace('<username/>', auth()->user()->_NAME, page('template_html/home.html'));
