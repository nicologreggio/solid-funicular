<?php

require_once(__DIR__."/../../DBC.php");
require_once(__DIR__."/user.model.php");

class UserRepository
{
    static public function getOne(string $email) : ?UserModel
    {
        $stm = DBC::getInstance()->prepare(
            "select * from USERS where _EMAIL = ?"
        );

        $stm->execute([$email]);

        $user = $stm->fetch();

        return $user ? UserModel::instanceFromUser($user) : null;
    }

    static public function insertOne(string $email, string $name, string $surname, string $city, string $address, int $cap, string $password, bool $isAdmin = false) : ?UserModel
    {
        $stm = DBC::getInstance()->prepare("
            INSERT INTO `USERS`(`_EMAIL`, `_NAME`, `_SURNAME`, `_CITY`, `_ADDRESS`, `_CAP`, `_ADMIN`, `_PASSWORD`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $res = $stm->execute([
            $email,
            $name,
            $surname,
            $city,
            $address,
            $cap,
            $isAdmin,
            $password
        ]);

        return $res ? new UserModel(DBC::getInstance()->lastInsertId("USERS"), $email, $name, $surname, $city, $address, $cap, $password, $isAdmin) : null;
    }
}
