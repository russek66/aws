<?php

namespace App\Register;

class Register
{

    public function __construct(
        private mixed $data,
        public mixed $response = null
    )
    {

        $this->filterData($this->data)
            ->doRegister();
    }

    private function doRegister(): void
    {
        if ($this->validateData() AND !$this->doesExist()) {
            // todo -> process registration
            $this->sendEmail()
                ?->registerUserInDatabase();
            // todo -> sent verification e-mail
        }
    }

    private function validateData(): bool
    {
        return (new RegisterValidateData($this->data))->validateData();
    }

    private function doesExist(): bool
    {
        return (new RegisterValidateExistence($this->data))->validateExistence();
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

    private function registerUserInDatabase(): void
    {
        if (!(new RegisterSaveNewUser($this->data))->registrationResult) {
            // todo -> logic
        }
    }

    private function sendEmail(): ?Register
    {
        //
        if () {
            return $this;
        }
        return null;
    }
}