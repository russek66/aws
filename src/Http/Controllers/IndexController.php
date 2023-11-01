<?php
//namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    public function index():void{
        $this->View->render('index/index');
    }

}