<?php

namespace Andrew45105\SimpleFrameworkCore\Containers;
use Andrew45105\SimpleFrameworkCore\Exceptions\ParamNotExistException;
use Andrew45105\SimpleFrameworkCore\Exceptions\ParamsFileNotFoundException;
use Andrew45105\SimpleFrameworkCore\Exceptions\ParamsFileNotValidException;

/**
 * Class ParamsContainer
 * 
 * Contains methods working with application parameters
 * 
 * @package Andrew45105\SimpleFrameworkCore\Containers
 */
class ParamsContainer
{

    private $paramsFileDir = '';
    private $paramsFileName = 'parameters.conf';
    private $requiredParams = [
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
        if (!$file = file_get_contents($this->paramsFileDir . '/' . $this->paramsFileName)) {
            throw new ParamsFileNotFoundException($this->paramsFileDir, $this->paramsFileName);
        }

        $requiredParamsCount = 0;

        foreach ($file as $params) {
            $params = explode('=', trim(strip_tags($params)));
            $name = trim(strip_tags($params[0]));
            $value = trim(strip_tags($params[1]));

            if (count($params) != 2 || $name == '' || $value == '') {
                throw new ParamsFileNotValidException($this->paramsFileName);
            }
            if (in_array($name, $this->requiredParams)) {
                $requiredParamsCount++;
            }
            $this->paramsList[$name] = $value;
        }

        if ($requiredParamsCount != count($this->requiredParams)) {
            throw new ParamsFileNotValidException($this->paramsFileName);
        }
    }

}