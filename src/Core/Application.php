<?php

declare(strict_types=1);

namespace App\Core;

use App\Http\Controllers\ErrorController;

class Application
{
    private ?string $controllerName;
    private ?string $actionName;
    private mixed $parameters;
    private mixed $controller;

    public function __construct()
    {
        $url = trim(Request::get(key: 'url'), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $this->controllerName = $url[0] ?? 'index';
        $this->actionName = $url[1] ?? 'index';

        unset($url[0], $url[1]);
        $this->parameters = array_values($url);

        $this->controllerName = ucwords($this->controllerName) . 'Controller';;
        if(file_exists(Config::get(key: 'PATH_CONTROLLER') . $this->controllerName . '.php')) {
            require Config::get('PATH_CONTROLLER') . $this->controllerName . '.php';

            if (!method_exists($this->controllerName, $this->actionName)) {
                (new ErrorController())->fatalError(message: 'FATAL_ERROR_PAGE_NOT_FOUND', errorPage: '404');
            }else {
                $this->controller = new $this->controllerName($this->actionName,...$this->parameters);
            }
        } else {
            (new ErrorController())->fatalError(message: 'FATAL_ERROR_PAGE_NOT_FOUND', errorPage: '404');
        }
    }
}