<?php
session_start();

unset($_SESSION['user']);
unset($_SESSION['username']);
unset($_SESSION['cart']);

header('Location: ' . $_SESSION['HTTP_REFERER']);
