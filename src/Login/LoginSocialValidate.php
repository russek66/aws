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
        private readonly ?Hybridauth $hybridauth,
        private ?bool $validationResult = null
    )
    {

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
        $userId = (new UserData([
            'user_id-social' => $userIdSocial,
            'user_provider_type' => $provider
        ]))->getUserIdBySocialId();

        $this->validationResult = (bool)$userId;
    }
}