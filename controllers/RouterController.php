<?php
class RouterController{
    private $controller;
    private $parameters;

    public function process($url){
        $parsedURL = $this->parseURL($url);
        if (empty($parsedURL[1])){
            $this->route('home');
        }
        $className = $this->convertToControllerName($parsedURL[1]);
        if(file_exists('controllers/'.$$className.'php')){
            echo "found";
            $this->controller = new $className;
        } else {
            $this->route('error');
        }
    }

    private function convertToControllerName($text){
        $text = str_replace('-', ' ', $text);
        $text = ucwords($text);
        $text = str_replace(' ', '', $text);
        return $text."Controller";
    }

    private function parseURL($url){
        $parsedURL = parse_url($url); // splits to query and path
        $parsedURL['path'] = ltrim($parsedURL['path'], "/");
        $parsedURL['path'] = trim($parsedURL['path']);

        return explode("/", $parsedURL['path']);
    }
}