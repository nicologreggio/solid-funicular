<?php
require_once(__DIR__.'/../inc/header_php.php');
redirectIfNotLogged();
if(isset($_REQUEST['id'])){
    $stm = DBC::getInstance()->prepare("
        SELECT *
        FROM QUOTES
        WHERE `_ID` = ?
    ");
    $stm->execute([
        $_REQUEST['id']
    ]);
    $quote = $stm->fetch();
    error_if($quote === false, 'La richiesta di ricerca cercata non è stata trovata');
    $page = page('../template_html/quote/show.html');



    $user = DBC::getInstance()->query("
        SELECT *
        FROM USERS
        WHERE _ID = $quote->_USER
    ")->fetch();

    $products = ""; 
    foreach(DBC::getInstance()->query("
        SELECT P.*, QP._QUANTITY as _QNT
        FROM PRODUCTS P JOIN QUOTE_PRODUCT QP ON P._ID = QP._PRODUCT_ID
        WHERE QP._QUOTE_ID = $quote->_ID
    ")->fetchAll() as $prod){
        $products .= '
        <li>
            <img src="'.base().$prod->_MAIN_IMAGE.'" alt="'.e($prod->_MAIN_IMAGE_DESCRIPTION).'" />
            <a href="../product/index.php" class="pt-2 d-block" title="visualizza prodotti">'.e($prod->_NAME).'</a>
            <p class="pl-2 pb-0 mb-1">Quantità: '.($prod->_QNT).'</p>
        </li>';
    }
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $quote->_CREATED_AT);

    $map = [
        '<products/>' => $products,
        '<user-name/>' => $user->_NAME.' '.$user->_SURNAME,
        '<user-email/>' => $user->_EMAIL ,
        '<user-address/>' => $user->_ADDRESS.' '.$user->_CITY.' ('.$user->_CAP.')',
        '<quote-date/>' => $quote->_CREATED_AT ,
        '<quote-date-text/>' => $date->format('d-m-Y').' alle '.$date->format('H:i') ,
        '<quote-phone/>' => $quote->_TELEPHONE ,
        '<quote-reason/>' => $quote->_REASON ,
        '<quote-company/>' => $quote->_COMPANY ,
        '<quote-id/>' => $quote->_ID ,
    ];
    foreach($map as $k => $v){
        $page = str_replace($k, $v, $page);
    }
    echo $page;
}
else{
    redirectTo('/admin/quote/index.php');
}