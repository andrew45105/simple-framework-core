<?php

use Andrew45105\SFC\Container\ParamsContainer;
use Andrew45105\SFC\Exception\DatabaseException;

/**
 * Prepare test database
 * 
 * Class DBPreparator
 */
class DBPreparator
{
    
    private $pdo;
    private $dbName;
    
    public function __construct(ParamsContainer $paramsContainer)
    {
        
        $host = $paramsContainer->getParam('database_host');
        $this->dbName = $paramsContainer->getParam('test_database_name');
        $user = $paramsContainer->getParam('database_user');
        $password = $paramsContainer->getParam('database_password');

        $dsn = "mysql:host=$host";
        $opt = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        );
        try {
            $this->pdo = new \PDO($dsn, $user, $password, $opt);
        } catch (\PDOException $e) {
            throw new DatabaseException('Can not create test database connection');
        }
    }
    
    public function prepare()
    {
        $query = sprintf(
            file_get_contents(__DIR__ . '/../sql/db.sql'),
            $this->dbName,
            $this->dbName,
            $this->dbName
        );
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }
    
    public function drop()
    {
        $query = "DROP DATABASE IF EXISTS `%s`";
        $stmt = $this->pdo->prepare(sprintf($query, $this->dbName));
        $stmt->execute();
    }

}