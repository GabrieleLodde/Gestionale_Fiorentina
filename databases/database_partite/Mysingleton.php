<?php
class Mysingleton extends PDO 
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
            $instance = new Mysingleton(
                "mysql:host=localhost;dbname=progetto_partite",
                "root",
                "",
                array(PDO::ATTR_PERSISTENT => true)
            );
        return $instance;
    }
}