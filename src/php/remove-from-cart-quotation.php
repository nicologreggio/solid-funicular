<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $productId = $_POST['product-id'] ?? $_SESSION['actual-product-id'];

    echo $productId;

    var_dump($_SESSION['cart']);

    unset($_SESSION['cart'][(int) $productId]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
