<?php
require_once(__DIR__.'/../imports.php');
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
    public function register($name, $surname, $city, $address, $cap, $email, $password){
        if($err = validate([
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'city' => $city,
            'address' => $address,
            'cap' => $cap,
            'password' => $password
        ], [
            'email' => ['email', 'required', 'max_length:100'],
            'name' => ['required', 'alphabetic:1', 'max_length:50'],
            'surname' => ['required', 'alphabetic:1,1', 'max_length:100'],
            'city' => ['required', 'max_length:100'],
            'address' => ['required', 'max_length:100'],
            'cap' => ['required', 'length:5', 'integer'],
            'password' => ['required', 'regex:/^[a-zA-Z1-9\.\,\_\-]*$/', 'min_length:5', 'max_length:1024'],
        ], [
            'email.required' => "E' obbligatorio inserire una email",
            'email.email' => "L'email inserita non è valida",
            'email.max_length' => "L'email può essere lunga al massimo 100 caratteri",

            'name.required' => "E' obbligatorio inserire un nome (una o più parole composte da lettere dell'alfabeto)",
            'name.alphabetic' => "Il nome inserito può contenere solo lettere dell'alfabeto",
            'name.max_length' => "Il nome inserito può essere lungo al massimo 50 caratteri", 

            'surname.required' => "E' obbligatorio inserire un cognome (uan parola composta da sole lettere dell'alfabeto)",
            'surname.alphabetic' => "Il nome inserito può contenere solo lettere dell'alfabeto",
            'surname.max_length' => "Il cognome inserito può essere lungo al massimo 100 caratteri", 

            'city.required' => "E' obbligatorio inserire una città",
            'city.max_length' => "Il nome della città inserita può essere al massimo lungo 100 caratteri",

            'address.required' => "E' obbligatorio inserire un indirizzo",
            'address.max_length' => "L'indirizzo inserito può essere lungo al massimo 100 caratteri",

            'cap.required' => "E' obbligatorio inserire un CAP",
            'cap.length' => "Il CAP deve essere lungo esattamente 5 caratteri numerici",
            'cap.integer' => "Il CAP deve essere composto da soli numeri",

            'password' => "E' obbligatorio inserire una password",
            'password.regex' => "La password per un amministratore può contenere solo lettere numeri .,_-",
            'password.min_length' => "La password deve essere almeno lunga 5 caratteri",
            'password.max_length' => "La password deve essere al massimo lunga 1024 caratteri",
        ])){ 
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