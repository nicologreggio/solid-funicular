<?php
function message($message = null){
    if($message){
        $_SESSION['admin.message'] = $message;
    } else {
        if(isset($_SESSION['admin.message'])){
            $mex = "<p>".$_SESSION['admin.message']."</p>";
            unset($_SESSION['admin.message']);
        }
        else {
            $mex = "";
        } 
        return $mex;
    }
}