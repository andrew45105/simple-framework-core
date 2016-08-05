<?php

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Contains methods for test DBConnection class
 *
 * Class DBConnectionTest
 */
class DBConnectionTest extends PHPUnit_Framework_TestCase
{

    public function testGetConnection()
    {
        $paramsContainer = new \Andrew45105\SFC\Container\ParamsContainer(__DIR__.'/data');
        $db = new \Andrew45105\SFC\Database\DBConnection($paramsContainer);
        $this->assertNotNull($db->getConnection());
    }

}