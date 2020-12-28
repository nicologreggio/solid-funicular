<?php
$page = file_get_contents('./template_html/error.html');
echo str_replace("<error-message/>", $_SESSION['admin.error'] ??  "C'è stato un errore, la pagina cercata potrebbe essere stata rimossa o spostata", $page);
if(isset($_SESSION['admin.error'])){
    unset($_SESSION['admin.error']);
}