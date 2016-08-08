<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/entity/Article.php';

use Andrew45105\SFC\Database\DBHelper;

class DBHelperTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var DBHelper
     */
    private $helper;

    public function setUp()
    {
        parent::setUp();
        $this->helper = new DBHelper();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->helper);
    }

    public function testGetUnderscoreName()
    {
        $this->assertEquals('some_camel_case_string', $this->helper->getUnderscoreName('SomeCamelCaseString'));
    }

    public function testGetEntityName()
    {
        $this->assertEquals('Article', $this->helper->getEntityName(new Article()));
    }
    
    public function testGetInsertingData()
    {
        $article = new Article();
        $article->setCreatedAt(time());
        $article->setTitle('test');
        $article->setText('test text');
        $data = $this->helper->getInsertingData($article);

        $this->assertCount(4, $data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('created_at', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('text', $data);
    }
    
    public function testGetValueType()
    {
        $this->assertEquals(\PDO::PARAM_INT, $this->helper->getValueType(12));
        $this->assertEquals(\PDO::PARAM_STR, $this->helper->getValueType('12'));
        $this->assertEquals(\PDO::PARAM_BOOL, $this->helper->getValueType(true));
        $this->assertEquals(\PDO::PARAM_NULL, $this->helper->getValueType(null));
        $this->assertEquals(\PDO::PARAM_STR, $this->helper->getValueType(12.12));
    }

    public function testValidateParamArray()
    {
        $this->assertTrue($this->helper->validateParamArray(['id' => 1]));
        $this->assertTrue($this->helper->validateParamArray(['id' => true]));
    }

    /**
     * @expectedException Andrew45105\SFC\Exception\ParamArrayNotValidException
     */
    public function testExceptionValidateParamArray()
    {
        $this->helper->validateParamArray(['title']);
    }

}