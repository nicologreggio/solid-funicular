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

    public function __construct(string $email, string $name, string $surname, string $city, string $address, int $cap, string $password, bool $isAdmin)
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

    public static function instanceFromUser($user) : UserModel
    {
        return new UserModel($user->_EMAIL, $user->_NAME, $user->_SURNAME, 
                                $user->_CITY, $user->_ADDRESS, $user->_CAP,
                                $user->_PASSWORD, $user->_ADMIN);
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

    public function isAdmin() : bool
    {
        return $this->isAdmin;
    }

    public function getPassword() : string
    {
        return $this->password;
    }
}
