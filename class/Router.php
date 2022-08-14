<?php

    class Router{
        public static $routes = [];

        //Handle action using Closure callback functionality to provide customized router ficility
        public static function route($action, Closure $callback)
        {
            $action = trim($action, '/');
            Router::$routes[$action] = $callback;
        }

         //dispatch initialized route that will call the specific closure function uing call_user_func
        public static function dispatch($action)
        {
            $action = trim($action, '/');
            if(array_key_exists($action, Router::$routes))
            {
                $callback = Router::$routes[$action];
                // echo call_user_func($callback);
                echo $callback();
            }
            else
            {
                http_response_code(404);
            }
        
        }
    }