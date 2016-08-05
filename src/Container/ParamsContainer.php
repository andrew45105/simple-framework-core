<?php

namespace Andrew45105\SFC\Container;

use Andrew45105\SFC\Exception\ParamNotExistException;
use Andrew45105\SFC\Exception\ParamsFileNotFoundException;
use Andrew45105\SFC\Exception\ParamsFileNotValidException;

/**
 * Class ParamsContainer
 * 
 * Contains methods working with application parameters
 * 
 * @package Andrew45105\SFC\Container
 */
class ParamsContainer
{

    private $paramsFileDir;
    private $paramsFileName = 'parameters.conf';
    private $requiredParams = [
        'site_url',
        'database_host',
        'database_name',
        'database_user',
        'database_password'
    ];

    private $paramsList;

    public function __construct($paramsFileDir)
    {
        $this->paramsFileDir = $paramsFileDir;
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

        if (!file_exists($this->paramsFileDir . '/' . $this->paramsFileName)) {
            throw new ParamsFileNotFoundException($this->paramsFileDir, $this->paramsFileName);
        }

        $file = file($this->paramsFileDir . '/' . $this->paramsFileName);

        $requiredParamsCount = 0;
        foreach ($file as $params) {
            $params = explode('=', trim(strip_tags($params)));

            if (count($params) != 2) {
                throw new ParamsFileNotValidException($this->paramsFileName);
            }

            $name = trim(strip_tags($params[0]));
            $value = trim(strip_tags($params[1]));

            if ($name == '' || $value == '') {
                throw new ParamsFileNotValidException($this->paramsFileName);
            }
            if (in_array($name, $this->requiredParams) && !isset($this->paramsList[$name])) {
                $requiredParamsCount++;
            }
            $this->paramsList[$name] = $value;
        }

        if ($requiredParamsCount != count($this->requiredParams)) {
            throw new ParamsFileNotValidException($this->paramsFileName);
        }
    }

}