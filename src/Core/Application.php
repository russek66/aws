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
        (new Router())->resolveEndPoint(uri: $this->request['uri'], method: strtolower($this->request['method']));
    }
}