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
        ["../images/products/5feb1efc3d06f.jpeg", "name 1", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 2", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 3", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 4", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 5", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 6", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 7", ],
        ["../images/products/5feb1efc3d06f.jpeg", "name 8", ]
    ];

    $productsList='<ul id="products-list">';

    
    
    for($i=0; $i<count($products); $i++){
        $productsList .= '<li class="category-product">' . '<a href="products.php?id="' . $i . '><img src="' . $products[$i][0] . '" />' . '<p>' . $products[$i][1] . '</p></a></li>';
    }

    $productsList .= '</ul>';

    $page=str_replace('<productsList />', $productsList, $page);

    return $page;
}

?>