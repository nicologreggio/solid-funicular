<?php
session_start();

require_once './utils/utils.php';


echo fetchAndFillCategories(file_get_contents('./index.html')); //mette i link nell'header coi nomi dal db

//eventuale altra roba propria di index, same per altre pagine


?>