<?php

namespace Andrew45105\SFC\Container;

/**
 * Class MainContainer
 *
 * The main container class
 * 
 * @package Andrew45105\SFC\Container
 */
class MainContainer
{
    /**
     * @var ParamsContainer
     */
    private $paramsContainer;
    
    public function __construct()
    {
        $this->paramsContainer = new ParamsContainer();
    }

    /**
     * @return ParamsContainer
     */
    public function getParamsContainer()
    {
        return $this->paramsContainer;
    }

}