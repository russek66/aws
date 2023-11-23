<?php

namespace App\Login;

use App\Core\Config;
use App\Core\Request;
use App\Core\Session\Session;
use App\Register\RegisterNewUser;
use App\Register\RegisterNewUserSocial;
use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;


class LoginSocial
{
    use Config;

    public function __construct(
        private readonly ?string $provider = null,
        private mixed $userProfile = null,
    )
    {
        // todo -> get provider valuer from session
    }

    public function doLoginSocial(
        LoginSocialValidate $loginSocialValidate = new LoginSocialValidate()
    ): bool
    {
        try {
            $hybridauth = new Hybridauth($this->get('HYBRIDAUTH'));
            $hybridauth->authenticate($this->provider);
            $adapter = $hybridauth->getAdapter($this->provider);
//            $tokens = $adapter->getAccessToken();
            $this->userProfile = $adapter->getUserProfile();
            $adapter->disconnect();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $validationResult = $loginSocialValidate->validateFirstTime(userIdSocial: $ID, provider: $this->provider);

        if (!$validationResult) {
            $registerNewSocialUser = (new RegisterNewUserSocial($this->userProfile));
            $registerNewSocialUser->registerUser();
            if ($registerNewSocialUser->registrationResult) {
                return false;
            }
        }

        return true;

    }

    public function doLogout(): bool
    {
        try {
            $hybridauth = new Hybridauth($this->get('HYBRIDAUTH'));
            $hybridauth->disconnectAllAdapters();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        (new Session())->destroy();
        return true;
    }
}