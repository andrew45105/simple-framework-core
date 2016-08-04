<?php

namespace Andrew45105\SimpleFrameworkCore\Exceptions;

class ParamNotExistException extends \Exception
{

    public function __construct($paramName, $code = 0, \Exception $previous = null) {
        parent::__construct(
            "Param {$paramName} does not exist",
            $code,
            $previous
        );
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}