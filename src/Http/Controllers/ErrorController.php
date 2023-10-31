<?php

namespace App\Http\Controllers;

use App\Core\ErrorView;

class ErrorController extends Controller
{
    public function basicError():void
    {
        (new ErrorView())->renderError(error: '404');
    }
}