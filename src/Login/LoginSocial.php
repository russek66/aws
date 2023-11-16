<?php

namespace App\Login;

class LoginSocial
{

    public function doLoginSocial(
        LoginValidate $loginValidate = new LoginValidate()
    ): bool {
        $validationResult = $loginValidate->validateSocialUser($token);
        if (!$validationResult) {
            return false;
        }

        return true;
    }
}