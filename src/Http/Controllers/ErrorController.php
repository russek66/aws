<?php

namespace App\Http\Controllers;

use App\Core\View\ViewError;
use App\Core\Log;

class ErrorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function basicError(string $message):void
    {
        (new ViewError())->renderError(error: $message);
        Log::info($message, ['extra' => 'information', 'about' => 'anything' ]);
    }

    public function fatalError(string $message, string $errorPage, array $data = null):void
    {
        (new ViewError())->renderFatalError(error: $errorPage);
        Log::error($message, ['extra' => 'information', 'about' => 'anything' ]);
    }
}