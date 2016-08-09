<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/Utils/DBPreparator.php';
require_once __DIR__.'/entity/Article.php';

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
     * @var DBPreparator
     */
    private $dbPreparator;

    /**
     * @var DBManager
     */
    private $db;

    public function setUp()
    {
        parent::setUp();
        $this->paramsContainer = new ParamsContainer(__DIR__.'/data');
        $this->dbPreparator = new DBPreparator($this->paramsContainer);
        $this->dbPreparator->prepare();
        $this->db = new DBManager($this->paramsContainer, true);
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->dbPreparator->drop();
        unset($this->dbPreparator);
        unset($this->db);
        unset($this->paramsContainer);
    }

    public function testGetConnection()
    {
        $this->assertNotNull($this->db->getConnection());
    }

    public function testGetById()
    {
        $this->assertEquals('1470648451', $this->db->getById('Article', 1)['created_at']);
        $this->assertNull($this->db->getById('Article', 7));
    }

    /**
     * @expectedException \PDOException
     */
    public function testExceptionGetById()
    {
        $this->db->getById('Entity', 1);
    }

    public function testGetBy()
    {
        $this->assertCount(1, $this->db->getBy('Article', ['title' => 'article2']));
        $this->assertCount(0, $this->db->getBy('Article', ['title' => 'article8']));
    }

    /**
     * @expectedException Andrew45105\SFC\Exception\ParamArrayNotValidException
     */
    public function testExceptionGetBy()
    {
        $this->db->getBy('Article', [true]);
    }

    public function testGetAll()
    {
        $this->assertCount(5, $this->db->getAll('Article'));
    }

    public function testSave()
    {
        $article = new Article();
        $article->setCreatedAt(time());
        $article->setTitle('test');
        $article->setText('test text');
        
        $this->assertTrue($this->db->save($article));
    }

    public function testDelete()
    {
        $this->assertTrue($this->db->delete('Article', 1));
    }

}