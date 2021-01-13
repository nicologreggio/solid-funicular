<?php

function fetchAndFillCategories($page, $currentCat=-1)
{
    //do the real db job
    $categories = ["La Categoria 1", "Categoria num 2", "Terza Categoria", "4 di numero", "L'ultima si, la 5"];

    foreach ($categories as $idx => $cat) {
        //<a href="categories.php/2"><cat-2/></a>
        if($idx == $currentCat){
            $link='<li id="currentLink">' . $cat . '</li>';
            $page=str_replace("<cat-name />", $cat, $page);
        }
        else{
            $link='<li><a href="categories.php?cat=' . $idx . '">' . $cat . '</a></li>';
        }
        $page=str_replace(("<cat-" . $idx . "/>"), $link, $page);
        //echo "<cat-" . ($idx+1) . "/>";
    }

    return $page;
}

function fetchAndFillProducts($page, $category){
    //fetch $category from db

    $products=[
        ["prod 1", "desc 1", "price 1"],
        ["prod 2", "desc 2", "price 2"],
        ["prod 3", "desc 3", "price 3"],
        ["prod 4", "desc 4", "price 4"],
        ["prod 5", "desc 5", "price 5"],
        ["prod 6", "desc 6", "price 6"],
        ["prod 7", "desc 7", "price 7"],
        ["prod 8", "desc 8", "price 8"]
    ];

    $productsList='<ul>';

    
    
    for($i=0; $i<count($products); $i++){
        $productsList .= '<li><p>' . $products[$i][0] . '</p>' . '<p>' . $products[$i][1] . '</p>' . '<p>' . $products[$i][2] . '</p></li>';
    }

    $productsList .= '</ul>';

    $page=str_replace('<productsList />', $productsList, $page);

    return $page;
}

?>