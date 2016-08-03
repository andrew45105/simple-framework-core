<?php

namespace App\Exceptions;

class ParamsFileNotFoundException extends \Exception
{
    
    public function __construct($dirName, $fileName, $code = 0, \Exception $previous = null) {
        parent::__construct(
            "File {$fileName} not found in {$dirName}",
            $code,
            $previous
        );
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}