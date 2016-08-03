<?php

namespace App\Container;
use App\Exceptions\ParamNotExistException;
use App\Exceptions\ParamsFileNotFoundException;
use App\Exceptions\ParamsFileNotValidException;

/**
 * Class for working with application parameters
 * 
 * Class ParamsContainer
 */
class ParamsContainer
{

    const PARAMS_FILE_DIR = '';
    const PARAMS_FILE_NAME = 'parameters.conf';
    const REQUIRED_PARAMS = [
        'database_host',
        'database_port',
        'database_name',
        'database_user',
        'database_password'
    ];

    private $paramsList;

    public function __construct()
    {
        $this->validateAndGetParams();
    }

    /**
     * Return value of the parameter
     *
     * @param string $name
     *
     * @throws ParamNotExistException
     *
     * @return string
     */
    public function getParam($name)
    {
        if (isset($this->paramsList[$name])) {
            return $this->paramsList[$name];
        } else {
            throw new ParamNotExistException($name);
        }
    }

    /**
     * Validate parameters
     *
     * @throws ParamsFileNotFoundException
     * @throws ParamsFileNotValidException
     */
    protected function validateAndGetParams()
    {
        if (!$file = file_get_contents(self::PARAMS_FILE_DIR . self::PARAMS_FILE_NAME)) {
            throw new ParamsFileNotFoundException(self::PARAMS_FILE_DIR, self::PARAMS_FILE_NAME);
        }

        $requiredParamsCount = 0;

        foreach ($file as $params) {
            $params = explode('=', trim(strip_tags($params)));
            $name = trim(strip_tags($params[0]));
            $value = trim(strip_tags($params[1]));

            if (count($params) != 2 || $name == '' || $value == '') {
                throw new ParamsFileNotValidException(self::PARAMS_FILE_NAME);
            }
            if (in_array($name, self::REQUIRED_PARAMS)) {
                $requiredParamsCount++;
            }
            $this->paramsList[$name] = $value;
        }

        if ($requiredParamsCount != count(self::REQUIRED_PARAMS)) {
            throw new ParamsFileNotValidException(self::PARAMS_FILE_NAME);
        }
    }

}