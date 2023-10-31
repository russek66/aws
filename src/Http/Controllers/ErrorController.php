<?php

namespace App\Http\Controllers;

use App\Core\ErrorView;
use App\Core\Log;

class ErrorController extends Controller
{
    public function basicError(string $message):void
    {
        (new ErrorView())->renderError(error: '404');
    }

    public function fatalError(string $message, string $errorPage):void
    {
        (new ErrorView())->renderFatalError(error: $errorPage);
        Log::info($message, ['extra' => 'information', 'about' => 'anything' ]);
    }
}