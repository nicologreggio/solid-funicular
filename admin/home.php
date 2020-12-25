<?php
require_once(__DIR__.'/header_php.php');
redirectIfNotLogged();
echo file_get_contents('template_html/home.html');
