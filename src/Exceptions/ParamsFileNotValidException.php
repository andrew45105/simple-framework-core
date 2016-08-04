<?php

namespace Andrew45105\SimpleFrameworkCore\Exceptions;

class ParamsFileNotValidException extends \Exception
{
    
    public function __construct($fileName, $code = 0, \Exception $previous = null) {
        parent::__construct(
            "File {$fileName} is not valid",
            $code,
            $previous
        );
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}