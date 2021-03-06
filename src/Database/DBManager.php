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

    public function __construct(ParamsContainer $paramsContainer, $isTestMode = false)
    {
        $this->dbHelper = new DBHelper();
        
        try {
            $host = $paramsContainer->getParam('database_host');
            $name = $isTestMode ? $paramsContainer->getParam('test_database_name') : $paramsContainer->getParam('database_name');
            $user = $paramsContainer->getParam('database_user');
            $password = $paramsContainer->getParam('database_password');
    
            $dsn = "mysql:host=$host;dbname=$name";
            $opt = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            );
            
            $this->pdo = new \PDO($dsn, $user, $password, $opt);
        } catch (\Exception $e) {
            die($e->getMessage());
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
        $tableName = $this->dbHelper->getUnderscoreName($entityName);
        $query = "SELECT * FROM `{$tableName}` WHERE id = :id LIMIT 1";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result ? $result[0] : null;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Getting array of objects, witch params correspond with {params}
     *
     * @param $entityName - short entity class name (without full path)
     * @param array $param
     * 
     * Param example - ['title' => 'article1']
     *
     * @return array
     */
    public function getBy($entityName, $param)
    {
        try {
            $this->dbHelper->validateParamArray($param);
    
            $tableName = $this->dbHelper->getUnderscoreName($entityName);
            $key = array_keys($param)[0];
            $value = array_values($param)[0];
    
            $query = "SELECT * FROM `{$tableName}` WHERE `{$key}` = ?";
        
            $stmt = $this->pdo->prepare($query);

            $type = $this->dbHelper->getValueType($value);
            $stmt->bindParam(1, $value, $type);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
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
        $tableName = $this->dbHelper->getUnderscoreName($entityName);
        $query = "SELECT * FROM `{$tableName}`";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
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
        $entityName = $this->dbHelper->getEntityName($entity);

        $tableName = $this->dbHelper->getUnderscoreName($entityName);
        $data = $this->dbHelper->getInsertingData($entity);
        
        $query = "INSERT INTO `{$tableName}` (%s) VALUES (%s)";

        $values = [];
        $fields = '';
        $subs = '';
        foreach ($data as $field => $value) {
            $subs .= "?, ";
            $fields .= "`{$field}`, ";
            $values[] = $value;
        }
        
        $subs = substr($subs, 0, strlen($subs) - 2);
        $fields = substr($fields, 0, strlen($fields) - 2);

        try {
            $stmt = $this->pdo->prepare(sprintf($query, $fields, $subs));

            for ($i = 0; $i < count($values); $i++) {
                $type = $this->dbHelper->getValueType($values[$i]);
                $stmt->bindParam($i + 1, $values[$i], $type);
            }
            $stmt->execute();
            
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return true;
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
        $tableName = $this->dbHelper->getUnderscoreName($entityName);
        $query = "DELETE FROM `{$tableName}` WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $id, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return true;
    }

}
