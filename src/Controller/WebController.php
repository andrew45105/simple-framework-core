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
     * @param string $view
     * @param array | null $data
     * 
     * @return string
     */
    protected function getTemplate($currentDir, $view, $data = null)
    {
        return $this->parser->parse(
            file_get_contents(
                $currentDir .
                $this->viewsDir .
                $this->getViewsFolderName() .
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
    
    private function getViewsFolderName()
    {
        $controllerPath = get_called_class();
        $paths = explode('\\', $controllerPath);
        $controllerName = array_pop($paths);
        return lcfirst(substr($controllerName, 0, -10)) . '/';
    }

}