<?php

class bdd
{
    public $conn;
    private static $instance;

    private function __construct()
    {
        $host = 'localhost';
        $dbname = 'equipe17';
        $user = 'root';
        $password = 'ynov';
        $this->conn = new PDO('mysql:host='. $host .';dbname=' . $dbname, $user, $password);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }


    public function execute($sql, $array)
    {
        $pre = $this->conn->prepare($sql);
        if(!$pre)
        {
            return print_r($pre->errorInfo());
        }
        $pre->execute($array);
    }

    public function select($sql)
    {
        return $this->conn->query($sql)->fetch();
    }

    public function selectAll($sql)
    {
        return $this->conn->query($sql)->fetchAll();
    }

    public function selectAllPrepare($sql, $array)
    {
        $pre = $this->conn->prepare($sql);
        $pre->execute($array);
        return $pre->fetchAll();
    }
}