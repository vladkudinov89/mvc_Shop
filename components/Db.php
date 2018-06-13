<?php

class Db
{
    
    public static function getConnection()
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

//        print_r($params);
//        die();
        

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->exec("set names utf8");
//        $this->_pdo = new PDO('mysql:dbname=shop-test;host=localhost', 'root', '');
        return $db;
    }

}
