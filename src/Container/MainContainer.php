<?php

namespace App\Container;
use App\Exceptions\ParamsFileNotFoundException;
use App\Exceptions\ParamsFileNotValidException;

/**
 * Class MainContainer
 */
class MainContainer
{

    const PARAMS_FILE_DIR = '';
    const PARAMS_FILE_NAME = 'parameters.conf';
    
    public function __construct()
    {
        $this->validateParamsFile();
    }

    /**
     * Return value of the parameter
     *
     * @param $name
     *
     * @return string
     */
    public function getParam($name)
    {

        
        
        
    }

    /**
     * Validate parameters
     * 
     * @throws ParamsFileNotFoundException
     * @throws ParamsFileNotValidException
     * 
     * @return boolean
     */
    protected function validateParamsFile()
    {
        if (!$file = file_get_contents(self::PARAMS_FILE_DIR . self::PARAMS_FILE_NAME)) {
            throw new ParamsFileNotFoundException(self::PARAMS_FILE_DIR, self::PARAMS_FILE_NAME);
        }

        foreach ($file as $param) {
            trim(str)

            throw new ParamsFileNotValidException(self::PARAMS_FILE_NAME);
        }


        return true;
    }

}