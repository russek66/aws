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
            // todo -> process registration
            $this->sendActivationEmail()
                ?->registerUserInDatabase()
                ?->generateResponse();
            // todo -> sent verification e-mail
        }
    }

    private function validateData(): bool
    {
        return (new RegisterValidateData($this->data))->validateData();
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

    private function registerUserInDatabase(): ?Register
    {
        if ((new RegisterNewUser(data: $this->data))->registrationResult) {
            // todo -> logic
            return $this;
        }
        return null;
    }

    private function sendActivationEmail(): ?Register
    {
        //
        if ((new Email(data:$this->data))->emailSendResult) {
            return $this;
        }
        return null;
    }

    private function generateResponse(): void
    {
        if ($this->registrationResult AND $this->emailSendResult) {
            $this->response = 1;
        } else {
            $this->response = 0;
        }
    }
}