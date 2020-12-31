<?php

namespace app\core;

/**
 * Class Request
 * 
 * @author Baptiste Lantran <lantranbaptiste@gmail.com>
 * @package app\core
 */
class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        //Compteur la longueur de l'uri, exemple: /users?id=15 vaudra 6
        $position = strpos($path,'?');

        //Si la position de '?' == false, alors on retourne le path
        if($position === false)
        {
            return $path;
        }
        
        return substr($path,0,$position);
        
        
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        return $this->method() === 'get';
    }

    public function isPost()
    {
        return $this->method() === 'post';
    }

    public function getBody()
    {
        $body = [];
        if($this->method()==='get')
        {
            foreach($_GET as $key => $value)
            {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);                
            }
        }

        if($this->method()==='post')
        {
            foreach($_POST as $key => $value)
            {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);                
            }
        }

        return $body;
    }
}