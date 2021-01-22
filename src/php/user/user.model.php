<?php

class UserModel
{
    private $id;
    private $email;
    private $name;
    private $surname;
    private $city;
    private $address;
    private $cap;
    private $isAdmin;
    private $password;

    public function __construct(string $id, string $email, string $name, string $surname, string $city, string $address, int $cap, string $password, bool $isAdmin)
    {
        $this->id = $id;
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
        return new UserModel($user->_ID, $user->_EMAIL, $user->_NAME, $user->_SURNAME, 
                                $user->_CITY, $user->_ADDRESS, $user->_CAP,
                                $user->_PASSWORD, $user->_ADMIN);
    }

    public function getId() : int
    {
        return $this->id;
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
