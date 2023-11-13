<?php

use App\Http\Controllers\Controller;
use App\Register\Register;

class RegisterController extends Controller
{

    public function __construct( )
    {
        parent::__construct();
    }

    public function index(): void
    {
        $this->view->render('register/index');
    }

    public function register(): void
    {
        $this->view->render('register/response', (new Register(data: $_POST))->response);
    }
}