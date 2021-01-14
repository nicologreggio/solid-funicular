<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $productId = $_SESSION['actual-product-id'];

    unset($_SESSION['cart'][$productId]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
