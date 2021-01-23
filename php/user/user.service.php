<?php

require_once(__DIR__."/user.repository.php");

class UserService
{
    static public function get(string $email) : ?UserModel
    {
        $user = UserRepository::getOne($email);

        return $user;
    }

    static public function login(string $email, string $password) : ?UserModel
    {
        $user = UserRepository::getOne($email);

        return ($user !== null && $user->getPassword() === $password) ? $user : null;
    }

    static public function signup(string $email, string $name, string $surname, string $city, string $address, int $cap, string $password, bool $isAdmin = false) : ?UserModel
    {
        return UserRepository::insertOne($email, $name, $surname, $city, $address, $cap, $password, $isAdmin);
    }
}
