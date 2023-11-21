<?php

namespace App\Login;

use App\Core\Config;
use App\User\UserData;
use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;

class LoginSocialValidate
{

    public function __construct()
    {
    }

    public function validateSocialUser(?string $userId, ?string $provider): bool
    {
        $accessToken = $this->getAccessToken($userId);

        try {
            $hybridauth = new Hybridauth(Config::get('HYBRIDAUTH'));
            $adapter = $hybridauth->getAdapter($provider);
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
}