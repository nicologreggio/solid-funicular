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

    static public function insertOne(UserModel $user) : ?UserModel
    {
        $stm = DBC::getInstance()->prepare("
            INSERT INTO `USERS`(`_EMAIL`, `_NAME`, `_SURNAME`, `_CITY`, `_ADDRESS`, `_CAP`, `_ADMIN`, `_PASSWORD`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $res = $stm->execute([
            $user->getEmail(),
            $user->getName(),
            $user->getSurname(),
            $user->getCity(),
            $user->getAddress(),
            $user->getCap(),
            $user->isAdmin(),
            $user->getPassword()
        ]);

        return $res ? $user : null;
    }
}
