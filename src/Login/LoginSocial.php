<?php

namespace App\Login;

use App\Core\Config;
use App\Core\Request;
use App\Core\Session\Session;
use App\Core\Session\SessionUsage;
use App\Register\RegisterNewUser;
use App\Register\RegisterNewUserSocial;
use Hybridauth\Adapter\AdapterInterface;
use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;


class LoginSocial
{
    use Config;
    use SessionUsage {
        Config::get as getConfig;
        SessionUsage::get insteadof Config;
    }

    public function __construct(
        private ?AdapterInterface $adapter = null,
        private ?string $provider = null,
        private mixed $userProfile = null,
        private ?Hybridauth $hybridauth = null
    )
    {
        try {
            $this->hybridauth = new Hybridauth($this->getConfig('HYBRIDAUTH'));
        } catch (Exception $e) {
            echo $e->getMessage();

            // todo -> show error
        }
        $this->provider = $this->get('provider');
    }

    public function doLoginSocial(): bool
    {
        $loginSocialValidate = new LoginSocialValidate($this->hybridauth);

        try {
            $this->hybridauth->authenticate($this->provider);
            $this->adapter = $this->hybridauth->getAdapter($this->provider);
            $this->userProfile = $this->adapter->getUserProfile();
//            $this->adapter->disconnect();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $validationResult = $loginSocialValidate->validateFirstTime(
            userIdSocial: $this->userProfile->identifier,
            provider: $this->provider
        );

        if (!$validationResult) {
            $registerNewSocialUser = (new RegisterNewUserSocial(
                userProfile: $this->userProfile,
                accessToken: $this->adapter->getAccessToken(),
                provider: $this->provider
            ));
            $registerNewSocialUser->registerUser();
            if ($registerNewSocialUser->registrationResult) {
                return false;
            }
        }

        return true;

    }

    public function doLogout(): bool
    {
        $this->hybridauth->disconnectAllAdapters();

        (new Session())->destroy();
        return true;
    }
}