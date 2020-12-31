<?php

namespace app\core;


/**
 * Class Router
 * 
 * @author Baptiste Lantran <lantranbaptiste@gmail.com>
 * @package app\core
 */
class Router
{
    /**
     * Array of routes
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Request
     *
     * @var Request
     */
    public $request;

    /**
     * Response
     *
     * @var Response
     */
    public $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path,$callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path,$callback)
    {
        $this->routes['post'][$path] = $callback;
    }


    public function resolve()
    {
        $path =$this->request->getPath();
        $method=$this->request->method();
        $callback=$this->routes[$method][$path] ?? false;
        if($callback===false)
        {
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }
        //Si c'est un string
        if(is_string($callback)){
            return $this->renderView($callback);
        }
        if(is_array($callback))
        {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request);
    }

    public function renderView($view,$params = [])
    {
        //Ceci est la navbar et le footer
        $layoutContent = $this->layoutContent();
        //Le content de la page
        $viewContent=$this->renderOnlyView($view,$params);
        //On remplace {{content}} par le content de la page sur le layout
        return str_replace('{{content}}',$viewContent,$layoutContent);
    }

    protected function layoutContent()
    {
        $layout=Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view,$params)
    {
        foreach($params as $key => $value)
        {
            $$key = $value;
        }
        
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}