<?php

namespace App\Login;

use App\Core\Config;
use App\Core\Request;
use App\Core\Session\Session;
use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;

class LoginSocial
{

    public function doLoginSocial(
        LoginValidate $loginValidate = new LoginValidate()
    ): bool {

        return true;
    }

    public function doLogout(): bool
    {
        try {
            $hybridauth = new Hybridauth(Config::get('HYBRIDAUTH'));
            $hybridauth->disconnectAllAdapters();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        (new Session())->destroy();
        return true;
    }
}