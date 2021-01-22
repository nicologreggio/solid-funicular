<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
$page = page('../template_html/quote/index.html');

$cur_page = preg_match('/^[0-9]+$/', $_REQUEST['page']?? '') ? $_REQUEST['page'] : 0;
$per_page = 8;
$stm = DBC::getInstance()->prepare('SELECT * FROM QUOTES ORDER BY _ID LIMIT :limit OFFSET :offset');
$stm->bindValue(':limit', (int) $per_page, PDO::PARAM_INT); 
$stm->bindValue(':offset', (int) $cur_page * $per_page, PDO::PARAM_INT); 
$stm->execute();

$quotes = "";
foreach(($stm->fetchAll() ?? []) as $quote){// 2021-01-02 19:50:49
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $quote->_CREATED_AT);
    $user = DBC::getInstance()->query("
        SELECT *
        FROM USERS 
        WHERE _ID = $quote->_USER
    ")->fetch();
    $quotes.='
    <li>
        <h2 class="strong m0 p0 pt-1 pb-1"><abbr title="Identificativo" class="strong">ID:</abbr> '.$quote->_ID.'</h2>
        <p class="m0 p0">Richiesta effettuata il <time datetime="'.$quote->_CREATED_AT.'">'.$date->format('d-m-Y').' alle '.$date->format('H:i').'</time></p>
        <p class="m0 p0 mt-2">
            <span class="strong">Utente:</span> <br />
            <a href="mailto:'.e($user->_EMAIL).'" title="Invia email all\'indirizzo '.e($user->_EMAIL).'">'.e($user->_NAME.' '.$user->_SURNAME).' ('.e($user->_EMAIL).')</a>
        </p>
        <p class="m0 p0 mt-2">
            <span class="strong">Città:</span> <br />
            '.e($user->_ADDRESS.' '.$user->_CITY.' ('.$user->_CAP.')').'
        </p>
        <a href="show.php?id='.$quote->_ID.'" class="button mt-2 mb-1 color-white" title="visualizza richiesta numero '.$quote->_ID.'">
            Visualizza richiesta di preventivo
        </a>
        <hr class="mt-3" />
    </li>
    ';
}
$page = str_replace('<quotes/>', $quotes, $page);



pagination($page, $per_page, $cur_page,  DBC::getInstance()->query(
    "SELECT count(*) FROM QUOTES"
)->fetchColumn());
echo str_replace('<quotes/>', $quotes, $page);
