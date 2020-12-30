<?php

require_once(__DIR__."/user.repository.php");

class UserService
{
    static public function login(string $email, string $password) : bool
    {
        $user = UserRepository::getOne($email);

        return $user !== null && $user->getPassword() === $password;
    }

    static public function signup(UserModel $user) : bool
    {
        return UserRepository::insertOne($user);
    }
}
