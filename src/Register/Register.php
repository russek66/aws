<?php

namespace App\Register;

use App\DataTransfer\RegisterDTO;
use App\Enum\RegisterReturnStatus;
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
                ?->sendActivationEmail();
        }
        $this->generateResponse();
    }

    private function validateData(): bool
    {
        $validation = (new RegisterValidateData($this->object))?->validateData();

        $this->setResponseCode($validation);
        $this->response['data']['validation'] = $validation->getValidationMessage();

        return $validation->getValidationResult();
    }

    private function doesUserExist(): bool
    {
        $validation = (new RegisterValidateExistence(object: $this->object))->validateExistence();

        $this->setResponseCode($validation);
        $this->response['data']['existence'] = $validation->getValidationMessage();

        return $validation->getValidationResult();
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

    private function setResponseCode($object): void
    {
        if ($object->getValidationResult()){
            $this->response = ['code' => RegisterReturnStatus::SUCCESS->value];
        } else {
            $this->response = ['code' => RegisterReturnStatus::FAILED->value];
        }
    }
}