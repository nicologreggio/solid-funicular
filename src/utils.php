<?php

function fetchAndFillCategories($page)
{
    //do the real db job
    $categories = ["La Categoria 1", "Categoria num 2", "Terza Categoria", "4 di numero", "L'ultima si, la 5"];

    foreach ($categories as $idx => $cat) {
        //<a href="categories.php/2"><cat-2/></a>
        $link='<a href="categories.php/' . ($idx+1) . '">' . $cat .'</a>';
        $page=str_replace(("<cat-" . ($idx+1) . "/>"), $link, $page);
        //echo "<cat-" . ($idx+1) . "/>";
    }

    return $page;
}

?>