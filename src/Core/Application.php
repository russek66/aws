<?php

class Application
{
    public function __construct(
        private ?string $controllerName = null,
        private ?string $actionName = null
    )
    {
        $url = trim(Request::get('url'), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $this->controllerName = isset($url[0]) ?? null;
        $this->actionName = isset($url[1]) ?? null;
    }
}