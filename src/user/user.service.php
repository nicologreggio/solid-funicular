<?php

require_once(__DIR__."/user.repository.php");

class UserService
{
    static public function login(string $email, string $password) : ?UserModel
    {
        $user = UserRepository::getOne($email);

        return ($user !== null && $user->getPassword() === $password) ? $user : null;
    }

    static public function signup(UserModel $user) : bool
    {
        return UserRepository::insertOne($user);
    }
}
