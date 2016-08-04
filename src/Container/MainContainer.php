<?php

namespace Andrew45105\SimpleFrameworkCore\Container;

use League\Container\Container;
use League\Route\RouteCollection;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

/**
 * Class MainContainer
 *
 * The main container class
 * 
 * @package Andrew45105\SimpleFrameworkCore\Container
 */
class MainContainer
{
    private $container;
    private $routeCollection;
    private $paramsContainer;
    
    public function __construct()
    {
        $this->container = new Container();
        $this->container->share('response', Response::class);
        $this->container->share('request', function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        $this->container->share('emitter', SapiEmitter::class);

        $this->paramsContainer = new ParamsContainer();

        $this->routeCollection = new RouteCollection($this->container);
    }
    
    public function getRouteCollection()
    {
        return $this->routeCollection;
    }

    public function createResponse()
    {
        $response = $this->routeCollection->dispatch(
            $this->container->get('request'), 
            $this->container->get('response')
        );
        $this->container->get('emitter')->emit($response);
    }

}