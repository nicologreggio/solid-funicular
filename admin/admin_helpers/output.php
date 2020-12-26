<?php
function e($value, $doubleEncode = true){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $doubleEncode);
}