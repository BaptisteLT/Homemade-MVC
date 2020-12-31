<?php

namespace app\core;

/**
 * Class Application
 * 
 * @author Baptiste Lantran <lantranbaptiste@gmail.com>
 * @package app\core
 */
class Application
{
    /**
     * Root directory
     *
     * @var String
     */
    public static $ROOT_DIR;

    /**
     * Router
     *
     * @var Router
     */
    public $router;

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

    /**
     * Application
     *
     * @var  Application
     */
    public static $app;

    /**
     * Base controller
     *
     * @var BaseController
     */
    public $baseController;

    public function __construct($rootPath)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }


    public function getController(): BaseController
    {
        return $this->baseController;
    }

    public function setController(BaseController $controller): void
    {
        $this->baseController=$controller;
    }
}