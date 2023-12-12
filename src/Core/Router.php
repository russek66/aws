<?php

declare(strict_types=1);

namespace App\Core;

use App\Http\Controllers\ErrorController;

class Router
{
    use Config;
    use Request {
        Config::get as getConfig;
        Request::get as getRequest;
        Request::post as postRequest;
    }

    private ?string $controllerName;
    private ?string $actionName;
    private mixed $parameters;
    private array $routes = [];

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod): void
    {

        $url = trim($this->getRequest(key: 'url'), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $this->controllerName = ucwords($url[0]) . 'Controller' ?? 'index';
        $this->actionName = $url[1] ?? 'index';

        unset($url[0], $url[1]);
        $this->parameters = array_values($url);

        $controllerFiles = [
            $this->getConfig('PATH_CONTROLLER') . $this->controllerName . '.php',
            $this->getConfig('PATH_CONTROLLER_ADMIN') . $this->controllerName . '.php'
        ];

        if ($controllerExists = array_filter($controllerFiles, 'file_exists')) {
            foreach ($controllerExists as $key => $value){
                    $value ?? require $value;
            }
            if (!method_exists($this->controllerName, $this->actionName)) {
                $this->handleNotFound(message: 'FATAL_ERROR_METHOD_NOT_FOUND', errorPage: '404');
            }else {
                (new $this->controllerName())->{$this->actionName}(...$this->parameters);
            }
        } else {
            $this->handleNotFound(message: 'FATAL_ERROR_CONTROLLER_NOT_FOUND', errorPage: '404');
        }
    }

    private function handleNotFound(string $message, string $errorPage): void
    {
        (new ErrorController())->fatalError($message, $errorPage);
    }
}