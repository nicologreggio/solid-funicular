<?php
require_once(__DIR__.'/inc/header_php.php');
auth()->logout();
redirectIfNotLogged();