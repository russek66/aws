<?php

namespace App\Login;

use App\Core\Request;
use App\Core\Session;

class LoginSocial
{

    public function doLoginSocial(
        LoginValidate $loginValidate = new LoginValidate()
    ): bool {
        $validationResult = $loginValidate->validateSocialUser(
            userId: Session::get(key: 'user_id'),
            provider: Session::get(key: 'provider'));

        if (!$validationResult) {
            return false;
        }
        return true;
    }
}