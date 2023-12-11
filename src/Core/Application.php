<?php

declare(strict_types=1);

namespace App\Core;

use App\Http\Controllers\ErrorController;

class Application
{

    public function __construct(protected array $request)
    {
    }


    public function run(): void
    {
        (new Router())->resolve($this->request['uri'], strtolower($this->request['method']));
    }
}