<?php

namespace App\Register;

use App\DTO\RegisterDTO;
use App\Register\Helper\FilterData;

class Register
{
    use FilterData;

    public function __construct(
        private RegisterDTO $object,
        public mixed $response = null
    )
    {
        $this->object = $this->doFilterData(object: $this->object);
        $this->doRegister();
    }

    private function doRegister(): void
    {
        if ($this->validateData() AND !$this->doesUserExist()) {
            $this->registerUserInDatabase()
                ?->sendActivationEmail()
                ?->generateResponse();
        }
    }

    private function validateData(): bool
    {
        return (new RegisterValidateData($this->object))->validateData()->getValidationResult();
    }

    private function doesUserExist(): bool
    {
        return (new RegisterValidateExistence(object: $this->object))->validateExistence();
    }

    private function registerUserInDatabase(): Register
    {
        if (!(new RegisterNewUser(data: $this->object))->registrationResult) {
            $this->response = 0;
        }
        return $this;
    }

    private function sendActivationEmail(): Register
    {
        if (!(new Email(data:$this->object))->emailSendResult) {
            $this->response = 0;
        }
        return $this;
    }

    private function generateResponse(): void
    {
//        todo -> rework response format and msg
        if ($this->response === 1) {
            echo "200 OK";
        } else {
            echo "500 ERROR";
        }
    }
}