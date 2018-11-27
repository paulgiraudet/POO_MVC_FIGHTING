<?php

class Database{
    //connection settings
    const   HOST = "localhost",
            DBNAME = "fightGame",
            LOGIN = "root",
            PWD = "";
        
    static public function DB(){
        $db = new PDO('mysql:host='.self::HOST.';dbname='.self::DBNAME, self::LOGIN, self::PWD);
        return $db;
    }
}
