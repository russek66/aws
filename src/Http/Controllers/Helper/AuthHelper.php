<?php

namespace App\Http\Controllers\Helper;

trait AuthHelper
{

    public function checkAuth($methodName, $parameters): void
    {
        if ($this->authStatus) {
            $this->$methodName($parameters);
        }else {
            $this->view->render(filename: "error/blocked");
        }
    }
}