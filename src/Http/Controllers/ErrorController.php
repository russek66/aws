<?php

namespace App\Http\Controllers;

use App\Core\ErrorView;
use App\Core\Log;

class ErrorController extends Controller
{
    public function basicError(string $message):void
    {
        (new ErrorView())->renderError(error: $message);
        Log::info($message, ['extra' => 'information', 'about' => 'anything' ]);
    }

    public function fatalError(string $message, string $errorPage):void
    {
        (new ErrorView())->renderFatalError(error: $errorPage);
        Log::error($message, ['extra' => 'information', 'about' => 'anything' ]);
    }
}