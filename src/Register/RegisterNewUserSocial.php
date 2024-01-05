<?php

namespace App\Register;

use App\Core\DatabaseFactory;
use App\Enum\RegisterAttemptStatus;
use App\Register\Helper\PasswordHash;
use DateTime;

class RegisterNewUserSocial implements NewUserInterface
{
    use PasswordHash;

    public function __construct(
        private readonly mixed $userProfile,
        private readonly mixed $accessToken,
        private readonly string $provider,
        private ?array $hashArray = null,
        public bool $registrationResult = true,
        private bool $result = true,
        private mixed $resultMessage = RegisterAttemptStatus::SUCCESS,
        private readonly DatabaseFactory $database = new DatabaseFactory()
    )
    {
        $this->hashArray = $this->generateHash($this->userProfile->userPassword);
        $this->registerUser();
    }

    public function registerUser(): void
    {
        $sql = "INSERT INTO users (
                user_name, 
                user_password_hash, 
                user_email, 
                user_creation_timestamp, 
                user_activation_hash, 
                user_activation_expiry,
                user_provider_type)
            VALUES (
                :user_name, 
                :user_password_hash, 
                :user_email, 
                :user_creation_timestamp, 
                :user_activation_hash, 
                :user_activation_expiry,
                :user_provider_type)";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query->execute([
            '
        :user_name' => $this->userProfile->userName,
            ':user_password_hash' => $this->hashArray['passwordHash'],
            ':user_email' => $this->userProfile->userEmail,
            ':user_creation_timestamp' => time(),
            ':user_activation_hash' => $this->hashArray['activationHash'],
            ':user_activation_expiry' => (new DateTime('+1 day'))->format(
                'Y-m-d H:i:s'),
            ':user_provider_type' => $this->provider
        ]);

        if ($query->rowCount() <=> 1) {
            $this->result =  false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_EMAIL_SEND;
        }
    }
}