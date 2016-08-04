<?php

namespace Andrew45105\SimpleFrameworkCore\Controller;

use Lex\Parser;

/**
 * Class WebController
 * 
 * The base web controller class
 * 
 * @package Andrew45105\SimpleFrameworkCore\Controller
 */
class WebController
{
    /**
     * @var \Lex\Parser
     */
    private $parser;
    private $viewsDir = '/../Resources/views/';
    
    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     * Return template for response body
     *
     * @param string $currentDir
     * @param string $view
     * @param array | null $data
     * 
     * @return string
     */
    protected function getTemplate($currentDir, $viewsFolder, $view, $data = null)
    {
        return $this->parser->parse(
            file_get_contents(
                $currentDir .
                $this->viewsDir .
                $viewsFolder .
                $view .
                '.lex'
            ),
            $data
        );
    }

    protected function getViewsDir()
    {
        return $this->viewsDir;
    }
    
    protected function setViewsDir($viewsDir)
    {
        $this->viewsDir = $viewsDir;
    }
    
    protected function getViewsFolderName()
    {
        $controllerPath = get_called_class();
        $paths = explode('\\', $controllerPath);
        $controllerName = array_pop($paths);
        return lcfirst(substr($controllerName, 0, -10));
    }
    
    protected function getCurrentDir()
    {
        return __DIR__;
    }

}