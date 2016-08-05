<?php

require_once __DIR__.'/../vendor/autoload.php';

use Andrew45105\SFC\Container\ParamsContainer;
use Andrew45105\SFC\Database\DBManager;

/**
 * Contains methods for test DBManager class
 *
 * Class DBDBManagerTest
 */
class DBManagerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ParamsContainer
     */
    private $paramsContainer;

    /**
     * @var DBManager
     */
    private $db;

    public function setUp()
    {
        parent::setUp();
        $this->paramsContainer = new ParamsContainer(__DIR__.'/data');
        $this->db = new DBManager($this->paramsContainer);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->db);
        unset($this->paramsContainer);
    }

    public function testGetConnection()
    {
        $this->assertNotNull($this->db->getConnection());
    }

    public function testGetById()
    {
        
    }

    public function testGetBy()
    {

    }

    public function testGetAll()
    {

    }

    public function testSave()
    {

    }

    public function testDelete()
    {

    }

}