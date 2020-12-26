<?php
require_once(__DIR__.'/../inc/imports.php');
class Admin{
    private $user;
    public function __construct($user){
        $this->user = $user;
    }
    public function user(){
        return $this->user;
    }
    public function guest(){
        return $this->user == false || $this->user->_ADMIN == false;
    }
    public function isLogged(){
        return !$this->guest();
    }
    public function logout(){
        unset($_SESSION['admin']);
        $this->user = null;
    }
    public function login($email, $password){
        if($err = validate([
            'email' => $email
        ], [
            'email' => ['email', 'required']
        ], [
            'email.required' => "E' obbligatorio inserire una email",
            'email.email' => "L'email inserita non è valida"
        ]) !== true){ 
            return $err;
        }
        $stm = DBC::getInstance()->prepare("
            SELECT * FROM USERS WHERE _ADMIN = 1 AND _EMAIL = ? AND _PASSWORD = ?
        ");
        $stm->execute([
            $email,
            $password
        ]);
        $user = $stm->fetch();
        if($user){
            $_SESSION['admin'] = $user;
            $this->user = $user;
            return true;
        } else {
            return false;
        }
    }
    public function register($name, $surname, $city, $address, $cap, $email, $password, $confirm){
        if(($err = validate([
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'city' => $city,
            'address' => $address,
            'cap' => $cap,
            'password' => $password,
            'confirm' => $confirm
        ], [
            'email' => ['email', 'required', 'max_length:100', 'unique:USERS,_EMAIL'],
            'name' => ['required', 'alphabetic', 'max_length:50', 'min_length:2'],
            'surname' => ['required', 'alphabetic', 'max_length:100', 'min_length:2'],
            'city' => ['required', 'max_length:100', 'min_length:2'],
            'address' => ['required', 'max_length:100', 'min_length:2'],
            'cap' => ['required', 'length:5', 'integer'],
            'password' => ['required', 'min_length:5', 'max_length:1024', 'equals:confirm'],
            'confirm' => ['required']
        ], [
            'email.required' => "E' obbligatorio inserire una email",
            'email.email' => "L'email inserita non è valida",
            'email.max_length' => "L'email può essere lunga al massimo 100 caratteri",
            'email.unique' => "L'email è già in uso",

            'name.required' => "E' obbligatorio inserire un nome (una o più parole composte da lettere dell'alfabeto)",
            'name.alphabetic' => "Il nome inserito può contenere solo lettere dell'alfabeto",
            'name.max_length' => "Il nome inserito può essere lungo al massimo 50 caratteri", 
            'name.min_length' => "Il nome deve essere almeno lungo 2 caratteri",

            'surname.required' => "E' obbligatorio inserire un cognome (uan parola composta da sole lettere dell'alfabeto)",
            'surname.alphabetic' => "Il nome inserito può contenere solo lettere dell'alfabeto",
            'surname.max_length' => "Il cognome inserito può essere lungo al massimo 100 caratteri", 
            'surname.min_length' => "Il cognome deve essere almeno lungo 2 caratteri",

            'city.required' => "E' obbligatorio inserire una città",
            'city.max_length' => "Il nome della città inserita può essere al massimo lungo 100 caratteri",
            'city.min_length' => "La città deve essere almeno lunga 2 caratteri",

            'address.required' => "E' obbligatorio inserire un indirizzo",
            'address.max_length' => "L'indirizzo inserito può essere lungo al massimo 100 caratteri",
            'address.min_length' => "L'indirizzo deve essere almeno lungo 2 caratteri",

            'cap.required' => "E' obbligatorio inserire un CAP",
            'cap.length' => "Il CAP deve essere lungo esattamente 5 caratteri numerici",
            'cap.integer' => "Il CAP deve essere composto da soli numeri",

            'password' => "E' obbligatorio inserire una password",
            'password.min_length' => "La password deve essere almeno lunga 5 caratteri",
            'password.max_length' => "La password deve essere al massimo lunga 1024 caratteri",
            'password.equals' => "La password non corrisponde alla conferma",

            'confirm.required' => "E' obbligatorio inserire la verifica",
        ])) !== true){ 
            return $err;
        }
        return DBC::getInstance()->prepare("
            INSERT INTO `USERS`(`_NAME`, `_SURNAME`, `_CITY`, `_ADDRESS`, `_CAP`, `_ADMIN`, `_EMAIL`, `_PASSWORD`) 
            VALUES (?, ?, ?, ?, ?, 1, ?, ?)"
        )->execute([
            $name,
            $surname,
            $city,
            $address,
            $cap,
            $email,
            $password
        ]);
    }
}
function auth(){
    return new Admin($_SESSION['admin'] ?? null);
}