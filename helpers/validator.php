<?php
class Rules{
    public static function email ($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    public function numeric($value){
        return is_numeric($value) == true;
    }
    public function alphabetic($value, $min = null, $max = null){
        if($min > $max) $max = $min;
        if($min != null && $max == null) $max = INF;
        $value = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $value);
        $value = trim($value);
        $words = explode(" ", $value);
        var_dump($min);
        var_dump( $max);
        if(sizeof($words) >= $min && sizeof($words) <= $max){
            var_dump('checking words');
            foreach($words as $word){
                if(!preg_match('/[a-zA-Z\ ]*/', $word)){
                    return false;
                }
            }
            return true;
        }
        return false;
    }
    public function required($value){
        return $value != null && $value != "" && $value == true ;
    }
    public function regex($value, $regex){
        return preg_match($regex, $value) == true;
    }
    public function min_length($value, $min){
        return strlen($value) >= $min;
    }
    public function max_length($value, $max){
        return strlen($value) <= $max;
    }
    public function length($value, $val){
        return strlen($value) == $val;
    }
    public function integer(){
        return preg_match("/^[1-9]*$/", $value) == true;
    }
}
function validate(array $values, array $rules, array $errors = []){
    $final_errors = [];
    $errors_sent = false;
    foreach($rules as $field_name => $field_rules){
        foreach($field_rules as $rule){
            $field_value = $values[$field_name] ?? null;
            $params = [];
            if($pos = strpos($rule, ':') && $rule == 'regex'){
                $params= substr($rule,$pos+1);
                $rule = substr($rule, 0, $pos);
            }
            else if($pos = strpos($rule, ':')){
                $params= explode(',', substr($rule,$pos+1));
                $rule = substr($rule, 0, $pos);
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
/*

/////////////////////////////////
//        PER FAR TEST         //
/////////////////////////////////

// validate email
var_dump(validate([
    ''
],[
    'email' => ['required', "email"]
],[
    'email.email' => "Inserita un email non valida",
    'email.required' => "E' necessaria una email"
]));
var_dump(validate([
    'testo' => 'asd '
],[
    'testo' => ["alphabetic:1"]
],[
    'testo.alphabetic' => "testo non alfabetico"
]));

var_dump(validate([
    'testo' => 'asddddde'
],[
    'testo' => ["regex:/asd*$/"]
],[
    'testo.regex' => "il testo deve essere asd con tante d finali quante ne vuoi"
]));

*/