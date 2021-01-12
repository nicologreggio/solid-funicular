<?php

function fetchCategories()
{
    //do the real db job
    $categories = ["La Categoria 1", "Categoria num 2", "Terza Categoria", "4 di numero", "L'ultima si, la 5"];

    $home=file_get_contents('./index.html');
    foreach ($categories as $idx => $cat) {
        $home=str_replace(("<cat-" . ($idx+1) . "/>"), $cat, $home);
        //echo "<cat-" . ($idx+1) . "/>";
    }

    echo $home;

}


fetchCategories();


?>