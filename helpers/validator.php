<?php
require_once(__DIR__."/../DBC.php");
class Rules{
    public static function email ($value){
        return self::regex($value, '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/');
    }
    public static function password($value) {
        return self::regex($value, '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,1024}$/');
    }
    public static function numeric($value){
        return is_numeric($value) == true;
    }
    public static function alphabetic($value, $min = null, $max = null){
        if($min == null && $max == null) {
            $min = 0;
            $max = INF;
        }
        else if($min > $max) {
            $max = $min;
        }
        else if($min != null && $max == null) {
            $max = INF;
        }
        $value = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $value);
        $value = trim($value);
        $words = explode(" ", $value);
        if(sizeof($words) >= $min && sizeof($words) <= $max){
            foreach($words as $word){
                if(!preg_match('/^[a-zA-Z\ ]*$/', $word)){
                    return false;
                }
            }
            return true;
        }
        return false;
    }
    public static function required($value){
        return $value != null && $value != "" && ($value == true || $value == 0) ;
    }
    public static function regex($value, $regex){
        return preg_match($regex, $value) == true;
    }
    public static function min_length($value, $min){
        return strlen($value) >= $min;
    }
    public static function max_length($value, $max){
        return strlen($value) <= $max;
    }
    public static function length($value, $val){
        return strlen($value) == $val;
    }
    public static function integer($value){
        return preg_match("/^[0-9]*$/", $value) == true;
    }
    public static function equals($value, $compare){
        return $value == $compare;
    }
    public static function unique($value, $table, $column){
        $sql = "SELECT count(*) FROM $table WHERE $column = ?"; 
        $result = DBC::getInstance()->prepare($sql); 
        $result->execute([$value]); 
        $number_of_rows = $result->fetchColumn(); 
        return $number_of_rows == 0;
    }
    public static function in_table($value, $table, $column){
        return !self::unique($value, $table, $column); 
    }
    public static function file($value, $size = 100){ // 100 Kb
        return isset($value)   
                && $value['error'] === UPLOAD_ERR_OK
                && $value['size'] > 0 
                && $value['size'] < $size * 1000;
    }

    public static function image($value, $width = null, $height = null){
        if(!self::file($value, INF)){
            return false;
        }
        $info = getimagesize($value['tmp_name']);
        return $info !== false
                && (
                    $info[2] !== IMAGETYPE_GIF ||
                    $info[2] !== IMAGETYPE_JPEG || 
                    $info[2] !== IMAGETYPE_PNG || 
                    $info[2] !== IMAGETYPE_JPEG2000
                );
    }
    public static function array_in_table(array $value, $table, $column){
        // probabilmente si può fare tutto con una query...
        foreach($value as $el){
            if(!self::in_table($el, $table, $column)){
                return false;
            }
        }
        return true;
    }
}
function validate(array $values, array $rules, array $errors = []){
    $final_errors = [];
    $errors_sent = false;
    foreach($rules as $field_name => $field_rules){
        foreach($field_rules as $rule){
            $field_value = $values[$field_name] ?? null;
            $params = [];
            $pos = strpos($rule, ':');
            if($pos){
                $real_rule = substr($rule, 0, $pos);
                if($real_rule == 'regex'){
                    $params= [substr($rule,$pos+1)];
                } else if($real_rule == "equals"){
                    $params = [$values[substr($rule,$pos+1)]];
                }
                else if($pos){
                    $params= explode(',', substr($rule,$pos+1));
                }
                $rule = $real_rule;
            }
            $validation = Rules::$rule($field_value, ...$params);
            if($validation == false){
                $errors_sent = true;
                if(array_key_exists($field_name.'.'.$rule, $errors)){
                    $final_errors[$field_name] = $final_errors[$field_name] ?? [];
                    $final_errors[$field_name][] = $errors[$field_name.'.'.$rule];
                }
            }
        }
    }
    if(empty($final_errors) && $errors_sent == false){
        return true;
    } 
    else if(empty($final_errors)){
        return false;
    }
    else {
        return $final_errors;
    }
}


/////////////////////////////////
//        PER FAR TEST         //
/////////////////////////////////
/*
var_dump(validate([
    'email' => 'admin@admin.admin'
],[
    'email' => ['required', "email"]
],[
    'email.email' => "Inserita un email non valida",
    'email.required' => "E' necessaria una email"
]));
var_dump(validate([
    'testo' => 'as1d'
],[
    'testo' => ["alphabetic:1"]
],[
    'testo.alphabetic' => "testo non alfabetico o troppo lungo"
]));

var_dump(validate([
    'testo' => 'asddddde'
],[
    'testo' => ["regex:/asd*$/"]
],[
    'testo.regex' => "il testo deve essere asd con tante d finali quante ne vuoi"
]));



var_dump(validate([
    'testo' => 'asddddde',
    'conferma' => 'asdddde'
],[
    'testo' => ["equals:conferma"]
],[
    'testo.equals' => "La conferma non è uguale"
]));


var_dump(validate([
    'email' => 'admin@admin.admin',
],[
    'email' => ["unique:USERS,_EMAIL"]
],[
    'email.unique' => "L'email esiste già nel DB"
]));
*/