<?php

namespace Andrew45105\SFC\Controller;

use Lex\Parser;

/**
 * Class WebController
 * 
 * The base web controller class
 * 
 * @package Andrew45105\SFC\Controller
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
     * @param string | null $viewName
     * @param array | null $data
     * 
     * @return string
     */
    protected function getTemplate($currentDir, $data = null, $viewName = null)
    {
        $viewName = $viewName ? $viewName : $this->getViewName();
        
        $path = $currentDir . $this->viewsDir . $this->getViewsFolderName() . $viewName . '.lex';

        $content = file_get_contents($path);
        
        if (!$content) {
            die("Parse file error ('{$path}')");
        }
        
        return $this->parser->parse($content, $data);
    }

    protected function getViewsDir()
    {
        return $this->viewsDir;
    }
    
    protected function setViewsDir($viewsDir)
    {
        $this->viewsDir = $viewsDir;
    }
    
    private function getViewsFolderName()
    {
        $controllerPath = get_called_class();
        $paths = explode('\\', $controllerPath);
        $controllerName = array_pop($paths);
        return lcfirst(substr($controllerName, 0, -10)) . '/';
    }

    private function getViewName()
    {
        $functionName = debug_backtrace()[2]['function'];
        return substr($functionName, 0, -6);
    }

}