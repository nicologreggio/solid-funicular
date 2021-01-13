<?php
function pagination(&$page, $per_page, $cur_page, $url, $total_of_products){
    $pagination = "";
    if($total_of_products > $per_page){
        $last = ceil($total_of_products / $per_page) - 1;
        $page = str_replace('<page-number-of/>', "Pagina del sito ".($cur_page + 1)." di ".($last + 1)." totali", $page);

        if($cur_page > 0){
            $pagination = '
            <a class="button" title="Vai alla prima pagina" href="index.php?page=0">
                &lt;&lt; <span>Prima</span>
            </a>
            <a class="button" title="Vai alla pagina precedente" href="index.php?page='.($cur_page-1).'">
                &lt; <span><abbr title="Pagina precedente">Prec.</abbr></span>
            </a>';
        }
        if($cur_page < $last){
            $pagination.= '
            <a class="button" title="Vai alla pagina successiva" href="index.php?page='.($cur_page+1).'">
                <span><abbr title="Pagina successiva">Succ.</abbr></span> &gt; 
            </a>
            <a class="button" title="Vai all\'ultima pagina" href="index.php?page='.($last).'">
                <span>Ultima</span> &gt;&gt; 
            </a>';
        }
    } else{
        $page = str_replace('<page-number-of/>', "", $page);
    }
    $page = str_replace("<pagination/>", $pagination, $page);
}