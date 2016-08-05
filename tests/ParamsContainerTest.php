<?php

require_once __DIR__.'/../vendor/autoload.php';

use Andrew45105\SFC\Container\ParamsContainer;

/**
 * Contains methods for test ParamsContainer class
 *
 * Class ParamsContainerTest
 */
class ParamsContainerTest extends PHPUnit_Framework_TestCase
{

    private $paramsContainer;

    public function setUp()
    {
        parent::setUp();
        $this->paramsContainer = new ParamsContainer(__DIR__.'/data');
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->paramsContainer);
    }

    public function testGetParam()
    {
        $this->assertEquals('127.0.0.1', $this->paramsContainer->getParam('database_host'));
    }

    /**
     * @expectedException Andrew45105\SFC\Exception\ParamsFileNotFoundException
     */
    public function testFileNotFoundExceptionGetParam()
    {
        $paramsContainer = new ParamsContainer(__DIR__.'/wrong/path');
    }

    /**
     * @expectedException Andrew45105\SFC\Exception\ParamsFileNotValidException
     */
    public function testFileNotValidExceptionGetParam()
    {
        $paramsContainer = new ParamsContainer(__DIR__.'/data/invalid');
    }

    /**
     * @expectedException Andrew45105\SFC\Exception\ParamNotExistException
     */
    public function testNotExistExceptionGetParam()
    {
        $this->paramsContainer->getParam('ooo');
    }

}