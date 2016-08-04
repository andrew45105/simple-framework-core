<?php

namespace App\Exceptions;

class ViewsDirectoryNotFoundException extends \Exception
{

    public function __construct($controllerName, $viewsDir, $code = 0, \Exception $previous = null) {
        parent::__construct(
            "Views directory for controller '{$controllerName}' is not found in {$viewsDir}",
            $code,
            $previous
        );
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}