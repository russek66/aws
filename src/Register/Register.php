<?php

namespace App\Register;

class Register
{

    public function __construct(
        private mixed $data,
        public mixed $response = null
    )
    {
        $this->filterData(data:$this->data)
            ->doRegister();
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
        return (new RegisterValidateData($this->data))->validateData()->getValidationResult();
    }

    private function doesUserExist(): bool
    {
        return (new RegisterValidateExistence(data:$this->data))->validateExistence();
    }

    public function filterData($data): Register
    {
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
            $data[$key] = stripslashes($data[$key]);
            $data[$key] = strip_tags($data[$key]);
        }

        $this->data = $data;

        return $this;
    }

    private function registerUserInDatabase(): Register
    {
        if (!(new RegisterNewUser(data: $this->data))->registrationResult) {
            $this->response = 0;
        }
        return $this;
    }

    private function sendActivationEmail(): Register
    {
        if (!(new Email(data:$this->data))->emailSendResult) {
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