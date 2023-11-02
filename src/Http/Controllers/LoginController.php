<?php

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function index():void {
        $this->View->render(filename: 'login/index');
    }

    public function login() {

    }

    public function loginWithCookie() {

    }

    public function logout() {

    }

}