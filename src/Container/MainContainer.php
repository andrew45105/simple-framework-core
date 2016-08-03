<?php

namespace App\Container;

use League\Container\Container;
use League\Route\RouteCollection;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

/**
 * The main container class
 *
 * Class MainContainer
 */
class MainContainer
{
    private $container;
    private $route;
    
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

        $this->route = new RouteCollection($this->container);
    }

    public function parseRoutes()
    {
        
    }

    public function createResponse()
    {
        $response = $this->route->dispatch(
            $this->container->get('request'), 
            $this->container->get('response')
        );
        $this->container->get('emitter')->emit($response);
    }
    
    protected function validateRoutes()
    {
        
    }

}