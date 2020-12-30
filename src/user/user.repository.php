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

        return $user ? new UserModel($user) : null;
    }

    static public function insertOne(UserModel $user) : bool
    {
        $stm = DBC::getInstance()->prepare("
            INSERT INTO `USERS`(`_NAME`, `_SURNAME`, `_CITY`, `_ADDRESS`, `_CAP`, `_ADMIN`, `_EMAIL`, `_PASSWORD`) 
            VALUES (?, ?, ?, ?, ?, 1, ?, ?)
        ");

        $res = $stm->execute([
            $user->getName(),
            $user->getSurname(),
            $user->getCity(),
            $user->getAddress(),
            $user->getCap(),
            $user->getEmail(),
            $user->getPassword()
        ]);

        return $res;
    }
}
