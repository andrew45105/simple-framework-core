<?php

namespace Andrew45105\SFC\Database;
use Andrew45105\SFC\Exception\ParamsArrayNotValidException;

/**
 * Contains additional methods for DBManager
 *
 * Class DBHelper
 *
 * @package Andrew45105\SFC\Database
 */
class DBHelper
{

    const PARAMS_MAX_COUNT = 10;

    /**
     * Return sql table name in underscore notation
     *
     * @param string $entityName 
     * @return string
     */
    public function getTableName($entityName)
    {
        return strtolower(
            preg_replace(
                '/([a-z])([A-Z])/', 
                '$1_$2', 
                trim(strip_tags($entityName))
            )
        );
    }

    /**
     * Validate params array
     * 
     * @param string $paramsArray
     *
     * @throws ParamsArrayNotValidException
     */
    public function validateParamsArray($paramsArray)
    {
        if (!is_array($paramsArray)) {
            throw new ParamsArrayNotValidException('Params is not array (' . gettype($paramsArray) . ' given)');
        }
        if (count($paramsArray) == 0) {
            throw new ParamsArrayNotValidException(
                'Params array is empty'
            );
        }
        if (count($paramsArray) > self::PARAMS_MAX_COUNT) {
            throw new ParamsArrayNotValidException(
                'Params array is too big (more than ' . self::PARAMS_MAX_COUNT . ' elements)'
            );
        }
        foreach ($paramsArray as $paramRow) {
            if (!is_array($paramRow)) {
                throw new ParamsArrayNotValidException(
                    'One of the parameter is not array (' . gettype($paramRow) . ' given)'
                );
            }
            if (count($paramRow) != 2) {
                throw new ParamsArrayNotValidException(
                    'One of the parameter is not valid array (elements count more or less then 2)'
                );
            }
            if (!is_string($paramRow[0])) {
                throw new ParamsArrayNotValidException(
                    'One of the parameter has invalid name (need string, ' . gettype($paramRow[0]) . ' given)'
                );
            }
            if (!is_string($paramRow[1]) && !is_int($paramRow[1]) && !is_float($paramRow[1])) {
                throw new ParamsArrayNotValidException(
                    'One of the parameter has invalid value (need string, integer or float, ' . gettype($paramRow[1]) . ' given)'
                );
            }
        }
    }

}