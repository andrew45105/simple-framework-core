<?php

/**
 * Describes article entity
 * 
 * Class Article
 * 
 * @package Andrew45105\SFC\Entity
 */
class Article
{
    /**
     * @var $id
     * @DBPrimaryKey
     */
    protected $id;

    /**
     * @var $createdAt
     */
    protected $createdAt;

    /**
     * @var $title
     */
    protected $title;

    /**
     * @var $text
     */
    protected $text;
    

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
    
}