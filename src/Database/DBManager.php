<?php

namespace Andrew45105\SFC\Database;

use Andrew45105\SFC\Container\ParamsContainer;
use Andrew45105\SFC\Exception\DatabaseException;

/**
 * Contains methods for work with database
 *
 * Class DBManager
 *
 * @package Andrew45105\SFC\Database
 */
class DBManager
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var DBHelper
     */
    private $dbHelper;

    public function __construct(ParamsContainer $paramsContainer)
    {
        $this->dbHelper = new DBHelper();
        
        $host = $paramsContainer->getParam('database_host');
        $name = $paramsContainer->getParam('database_name');
        $user = $paramsContainer->getParam('database_user');
        $password = $paramsContainer->getParam('database_password');

        $dsn = "mysql:host=$host;dbname=$name";
        $opt = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
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

    /**
     * Getting object with id = {id}
     *
     * @param $entityName - short entity class name (without full path)
     * @param $id
     *
     * @return array
     */
    public function getById($entityName, $id)
    {
        $tableName = $this->dbHelper->getTableName($entityName);
        $query = "SELECT * FROM `{$tableName}` WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Getting array of objects, witch params correspond with {params}
     *
     * @param $entityName - short entity class name (without full path)
     * @param array $params
     *
     * @return array
     */
    public function getBy($entityName, array $params)
    {
        $this->dbHelper->validateParamsArray($params);
        $tableName = $this->dbHelper->getTableName($entityName);

        $query = "SELECT * FROM $tableName WHERE ";

        foreach ($params as $param) {
            $query .= "`{$param[0]}` = ? OR ";
        }

        $query = substr($query, 0, strlen($query) - 4);

        $stmt = $this->pdo->prepare($query);

        $count = 0;
        foreach ($params as $param) {
            $type = is_int($param[1]) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $stmt->bindParam(++$count, $value, $type);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Getting array of all objects
     *
     * @param $entityName - short entity class name (without full path)
     *
     * @return array
     */
    public function getAll($entityName)
    {
        $tableName = $this->dbHelper->getTableName($entityName);
        $query = "SELECT * FROM `{$tableName}`";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Saves entity to database
     *
     * @param $entity - object
     * 
     * @return boolean
     */
    public function save($entity)
    {

    }

    /**
     * Deleting entity with id = {id}
     *
     * @param $entityName - short entity class name (without full path)
     * @param int $id
     * 
     * @return boolean
     */
    public function delete($entityName, $id)
    {

    }

}
