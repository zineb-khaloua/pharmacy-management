<?php

namespace core;

use PDO;
use PDOException;

class DB{

//singleton concept
private static $instance=null;
private $connection;

public function __construct()
{
    try{
        $this->connection=new PDO("mysql:host=localhost;dbname=pharmacy_management","root","");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "connection failed".$e->getMessage();
    }
}

public static function getInstance(){
    if(self::$instance==null)
    {
        self::$instance=new self();
    }
    return self::$instance;
}
public function getConnection(){
    return $this->connection;
}

}