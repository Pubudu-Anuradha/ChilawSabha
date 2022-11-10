<?php

class App
{
    // Setting Default Controller, Method and Parameters
    private $controller = 'Home';
    private $method = 'index';
    private $parameters = [];

    public function __construct()
    {
        session_start();
        $url = $this->parseUrl();
        var_dump($url);
        var_dump($_SESSION);
        if (isset($url[0])) {
            if ($url[0] != 'index.php') {
                if (file_exists('app/controllers/' . $url[0] . '.php')) {
                    // The requested controller exists, so change the default
                    $this->controller  = $url[0];
                    unset($url[0]);
                }
            }
        }

        // Get the definition of the controller and get an instance of it
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                // The requested method of the controller exists, so change the default
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // If there are more values left in $url,
        // set them as the parameters for the method
        $this->parameters = $url ? array_values($url) : [];

        // Call the method of the controller and pass the parameters to it
        call_user_func_array([$this->controller, $this->method], $this->parameters);
    }

    private function parseUrl()
    {
        return isset($_GET['url']) ?
            // Splitting the url given by the query string and returning it as an array
            explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL))
            : [];
    }
}
