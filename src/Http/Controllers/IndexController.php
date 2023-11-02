<?php

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index():void
    {
        $this->View->render(filename: 'index/index');
    }

    public function showIndex(mixed $data):void
    {
        $this->View->render(filename: 'index/index', data:
            [
                'user' => $data
            ]
        );
    }
}