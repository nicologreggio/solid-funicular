<?php

function fillPageWithError($page, $err)
{
    $page = str_replace('<error-db/>', "", $page);
    
    foreach($err as $k => $errors)
    {
        $msg = "<ul class='errors-list'>";
    
        
        foreach($errors as $error)
        {
            $msg .= "<li> $error </li>";
        }
        
        $msg .= "</ul>";
        $page = str_replace("<error-$k/>", $msg, $page);
    }

    return $page;
}

function fetchAndFillCategories($page, $current=-1, $isProduct=false)
{
    //do the real db job
    $categories = ["La Categoria 1", "Categoria num 2", "Terza Categoria", "4 di numero", "L'ultima si, la 5"];

    foreach ($categories as $idx => $cat) {
        //<a href="categories.php/2"><cat-2/></a>
        if($idx == $current){
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

function base()
{
    return str_replace(PHP_EOL, '', file_get_contents(__DIR__.'/../.base_path') ?? "");
}
