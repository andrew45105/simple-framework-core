<?php

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Contains methods for test ParamsContainer class
 *
 * Class DBTest
 */
class ParamsContainerTest extends PHPUnit_Framework_TestCase
{

    public function testSuccessGetParam()
    {
        $paramsContainer = new \Andrew45105\SFC\Container\ParamsContainer(__DIR__.'/data');
        $this->assertEquals('127.0.0.1', $paramsContainer->getParam('database_host'));
    }

    /**
     * @expectedException \Andrew45105\SFC\Exception\ParamsFileNotFoundException
     */
    public function testFileNotFoundExceptionGetParam()
    {
        $paramsContainer = new \Andrew45105\SFC\Container\ParamsContainer(__DIR__.'/wrong/path');
    }

    /**
     * @expectedException \Andrew45105\SFC\Exception\ParamsFileNotValidException
     */
    public function testFileNotValidExceptionGetParam()
    {
        $paramsContainer = new \Andrew45105\SFC\Container\ParamsContainer(__DIR__.'/data/invalid');
    }

    /**
     * @expectedException \Andrew45105\SFC\Exception\ParamNotExistException
     */
    public function testNotExistExceptionGetParam()
    {
        $paramsContainer = new \Andrew45105\SFC\Container\ParamsContainer(__DIR__.'/data');
        $paramsContainer->getParam('ooo');
    }

}