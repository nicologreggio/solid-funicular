<?php 
function saveFromRequest($key){
    try{
        $name = $_FILES[$key]["name"];
        $junk = explode(".", $name);
        $ext = end($junk);
        $loc = '../../images/products/'.uniqid().'.'.$ext;
        if (!move_uploaded_file(
            $_FILES[$key]['tmp_name'],
            $loc
        )) {
            return false;
        }

        return $loc;
    } catch (RuntimeException $e) {
        return false;
    }
}