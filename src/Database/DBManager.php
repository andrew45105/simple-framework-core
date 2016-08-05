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
     * @param $class - class of needed object
     * @param $id
     */
    public function getById($class, $id)
    {

    }

    /**
     * Getting array of objects, witch params correspond with {params}
     *
     * @param $class - class of needed objects
     * @param array $params
     */
    public function getBy($class, array $params)
    {

    }

    /**
     * Getting array of all objects
     *
     * @param $class - class of needed objects
     */
    public function getAll($class)
    {

    }

    /**
     * Saves entity to database
     *
     * @param $entity - object
     */
    public function save($entity)
    {

    }

    /**
     * Deleting entity with id = {id}
     *
     * @param $class - class of needed object
     * @param int $id
     */
    public function delete($class, $id)
    {

    }

}
