<?php

namespace App\Database;

use Andrew45105\SFC\Container\ParamsContainer;
use Andrew45105\SFC\Exception\DatabaseException;

/**
 * Contains methods for work with database
 *
 * Class DBConnection
 *
 * @package App\Database
 */
class DBConnection
{

    private $pdo;

    public function __construct(ParamsContainer $paramsContainer)
    {
        $this->paramsContainer = $paramsContainer;

        $host = $this->paramsContainer->getParam('database_host');
        $name = $this->paramsContainer->getParam('database_name');
        $user = $this->paramsContainer->getParam('database_user');
        $password = $this->paramsContainer->getParam('database_password');

        $dsn = "mysql:host=$host;dbname=$name";
        $opt = array(
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        );
        try {
            $this->pdo = new \PDO($dsn, $user, $password, $opt);
        } catch (\PDOException $e) {
            throw new DatabaseException('Can not create database connection');
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

}