<?php

namespace App\Login;

use App\Core\Config;
use App\User\UserData;
use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;

class LoginSocialValidate
{
    use Config;

    public function __construct(
        protected ?Hybridauth $hybridauth = null
    )
    {
        try {
            $this->hybridauth = new Hybridauth($this->get('HYBRIDAUTH'));
        } catch (Exception $e) {
            echo $e->getMessage();

            // todo -> show error
        }
    }

    public function validateSocialUser(?string $userId, ?string $provider): bool
    {
        $accessToken = $this->getAccessToken($userId);

        try {
            $adapter = $this->hybridauth->getAdapter($provider);
            $adapter->setAccessToken($accessToken);
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    private function getAccessToken(?string $userId): mixed
    {
        return (new UserData(
            [
                'user_id' => $userId,
            ]
        ))->getUserTokenById();
    }

    public function validateFirstTime($userIdSocial, ?string $provider): mixed
    {
        // todo -> (new UserData)->getUserIdSocial($provider)
    }
}