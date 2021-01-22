<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = array();

    $productId = $_SESSION['actual-product-id'];
    $quantity = (int) $_POST['quantity'];

    if($quantity >= 1)
    {
        $_SESSION['cart'][$productId] = $quantity;
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
