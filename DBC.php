<?php
require_once(__DIR__.'/helpers/credentials.php');

class DBC{
    protected static $connection;

    public static function getInstance() : PDO {
        if(self::$connection) return self::$connection;
        try{
            $credentials = db_credentials();
            self::$connection = new PDO(
                $credentials['dsn'], 
                $credentials['user'], 
                $credentials['password']
            );
            self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$connection;
        } catch(PDOException $ex){
            echo $ex->getMessage();
            echo $ex->getTraceAsString();
            die();
        }
    }
}