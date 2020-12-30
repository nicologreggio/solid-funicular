<?php

class UserModel
{
    private string $email;
    private string $name;
    private string $surname;
    private string $city;
    private string $address;
    private int $cap;
    private bool $isAdmin;
    private string $password;

    public function __constructor(string $email, string $name, string $surname, string $city, string $address, int $cap, bool $isAdmin, string $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->city = $city;
        $this->address = $address;
        $this->cap = $cap;
        $this->isAdmin = $isAdmin;
        $this->password = $password;
    }

    public function __construct($user)
    {
        $this->email = $user->_EMAIL;
        $this->name = $user->_NAME;
        $this->surname = $user->_SURNAME;
        $this->city = $user->_CITY;
        $this->address = $user->_ADDRESS;
        $this->cap = $user->_CAP;
        $this->isAdmin = $user->_ADMIN;
        $this->password = $user->_PASSWORD;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getSurname() : string
    {
        return $this->surname;
    }

    public function getCity() : string
    {
        return $this->city;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function getCap() : int
    {
        return $this->cap;
    }

    public function getIsAdmin() : bool
    {
        return $this->isAdmin;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public static function validateUser(UserModel $user)
    {
        return validate([
            'email' => $user->email,
            'name' => $user->name,
            'surname' => $user->surname,
            'city' => $user->city,
            'address' => $user->address,
            'cap' => $user->cap,
            'password' => $user->password,
            'confirm' => $user->confirm
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
        ]);
    }
}
