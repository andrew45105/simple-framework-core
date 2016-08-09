<?php

namespace Andrew45105\SFC\Database;

use Andrew45105\SFC\Exception\ParamArrayNotValidException;
use Andrew45105\SFC\Database\AnnotationsHelper;

/**
 * Contains additional methods for DBManager
 *
 * Class DBHelper
 *
 * @package Andrew45105\SFC\Database
 */
class DBHelper
{

    /**
     * @var AnnotationsHelper
     */
    private $annotationsHelper;

    public function __construct()
    {
        $this->annotationsHelper = new AnnotationsHelper();
    }

    /**
     * Return string in underscore notation
     *
     * @param string $name
     * @return string
     */
    public function getUnderscoreName($name)
    {
        return strtolower(
            preg_replace(
                '/([a-z])([A-Z])/', 
                '$1_$2', 
                trim(strip_tags($name))
            )
        );
    }

    /**
     * Return entity name
     * 
     * @param $entityObject
     * @return string
     */
    public function getEntityName($entityObject)
    {
        $entityPath = explode('\\', get_class($entityObject));
        return array_pop($entityPath);
    }

    /**
     * Return array of sql fields & values for inserting object
     * 
     * @param $entityObject
     * @return array
     */
    public function getInsertingData($entityObject)
    {
        $data = [];

        $rc = new \ReflectionClass($entityObject);
        $properties = $rc->getProperties();

        foreach ($properties as $property) {

            if ($this->annotationsHelper->isPrimaryKey($property)) {
                continue;
            }
            
            $camelCaseName = $property->getName();
            $underscoreName = $this->getUnderscoreName($camelCaseName);

            try {
                $method = $rc->getMethod('get' . $camelCaseName);
                $value = $method->invoke($entityObject);
            } catch (\ReflectionException $e) {
                die($e->getMessage());
            }

            $data[$underscoreName] = $value;
        }

        return $data;
    }

    /**
     * Return PDO-type of the parameter value
     *
     * @param $value
     * @return int
     */
    public function getValueType($value)
    {
        $type = \PDO::PARAM_STR;
        if (is_int($value)) {
            $type = \PDO::PARAM_INT;
        } elseif (is_bool($value)) {
            $type = \PDO::PARAM_BOOL;
        } elseif (is_null($value)) {
            $type = \PDO::PARAM_NULL;
        }
        return $type;
    }

    /**
     * Validate param array
     * 
     * @param string $paramArray
     *
     * @throws ParamArrayNotValidException
     * 
     * @return boolean
     */
    public function validateParamArray($paramArray)
    {
        if (!is_array($paramArray)) {
            throw new ParamArrayNotValidException('Param is not array, ' . gettype($paramArray) . ' given');
        }
        if (count($paramArray) != 1) {
            throw new ParamArrayNotValidException('Param array contains more or less than 1 element');
        }
        $key = array_keys($paramArray)[0];
        if (!is_string($key)) {
            throw new ParamArrayNotValidException('Param name must be a string, ' . gettype($key) . ' given');
        }
        return true;
    }

}