<?php
class Mysingleton1 extends PDO 
{
    private static $instance;
    protected $host;
    protected $user;
    protected $psw;
    protected $persistent;

    private function __construct($host, $user, $psw, $persistent)
    {
        parent::__construct($host, $user, $psw, $persistent);
    }

    public static function getInstance()
    {
        if (!isset($instance))
            $instance = new Mysingleton1(
                "mysql:host=localhost;dbname=progetto_fiorentina",
                "root",
                "",
                array(PDO::ATTR_PERSISTENT => true)
            );
        return $instance;
    }
}