<?php

namespace App\Http\Controllers;

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

    public function register(): mixed
    {
        return $this->view->renderJSON((new Register(data: $_POST))->response);
    }
}