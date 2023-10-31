<?php

declare(strict_types=1);

use App\Http\Controllers\ErrorController;

class Application
{
    public function __construct(
        private ?string $controllerName,
        private ?string $actionName,
        private mixed $parameters,
        private mixed $controller
    )
    {
        $url = trim(Request::get('url'), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $this->controllerName = isset($url[0]) ?? null;
        $this->actionName = isset($url[1]) ?? null;

        unset($url[0], $url[1]);
        $this->parameters = array_values($url);
        $this->controllerName = ucwords($this->controllerName) . 'Controller';

        if(file_exists(Config::get('PATH_CONTROLLER') . $this->controllerName . '.php')) {
            require Config::get('PATH_CONTROLLER') . $this->controllerName . '.php';
            $this->controller = new $this->controllerName;
        } else {
            (new ErrorController)->error404();
        }
    }
}