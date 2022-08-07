<?php

namespace Src\core\router;

use Src\exceptions\RouteNotFoundException;

final class Router {

    private array $routes = [];

    private static ?self $instance = null;


    private function __construct()
    {}

    public static function getInstance():self {

        if(is_null(self::$instance)) {

            self::$instance = new self;

        }

        return self::$instance;
    }

    public function get(string $prettyUrl, callable|array $callback):self {

        $this->register('get', $prettyUrl, $callback);

        return $this;

    }

    public function post(string $prettyUrl, callable|array $callback):self {

        $this->register('post', $prettyUrl, $callback);

        return $this;

    }

    private function register(string $requestMethod, string $prettyUrl, callable|array $callback) {

        $this->routes[$requestMethod][$prettyUrl] = $callback;

    }

    public function resolve(string $requestMethod, string $urlQuery) {

        $parsedUrl = explode('/', $urlQuery);

        $callback = $this->routes[ strtolower($requestMethod) ][ array_shift($parsedUrl) ] ?? false;

        if (! $callback) {

            throw new RouteNotFoundException();
        }

        if (is_array($callback)) {

            $controller = key($callback);
            $action = $callback[$controller];

            return (new $controller)->init($parsedUrl)->runAction($action);
        }

        return $callback();

    }

    

}