<?php
session_start();

require_once(__DIR__."/utils/utils.php");

unset($_SESSION['user']);
unset($_SESSION['username']);
unset($_SESSION['cart']);

if(isset($_SESSION['HTTP_REFERER']))
{
    header('Location: ' . $_SESSION['HTTP_REFERER']);
}
else
{
    header('Location: '.base().'/');
}
