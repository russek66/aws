<?php

namespace App\Register;

use App\DataTransfer\RegisterDTO;
use App\Email\Email;
use App\Enum\RegisterReturnStatus;
use App\Register\Helper\FilterData;
use App\Register\Helper\GetResult;

class Register
{
    use FilterData;
    use GetResult;

    public function __construct(
        private RegisterDTO $RDTO,
        public mixed $response = null
    )
    {
        $this->RDTO = $this->doFilterData(object: $this->RDTO);
        $this->doRegister();
    }

    private function doRegister(): void
    {
        if ($this->validateData() AND !$this->doesUserExist()) {
            $this->registerUserInDatabase()
                ?->sendActivationEmail();
        }
    }

    private function validateData(): bool
    {
        $validation = (new RegisterValidateData(RDTO: $this->RDTO));
        $validation->validateData();

        $this->setResponseCode($validation);
        $this->setParams($validation);
        $this->response['data']['validation'] = $this->getMessage();

        return $this->getResult();
    }

    private function doesUserExist(): bool
    {
        $validation = (new RegisterValidateExistence(RDTO: $this->RDTO));
        $validation->validateExistence();

        $this->setResponseCode($validation);
        $this->setParams($validation);
        $this->response['data']['existence'] = $this->getMessage();

        return $this->getResult();
    }

    private function registerUserInDatabase(): Register
    {
        $registration = (new RegisterNewUser(RDTO: $this->RDTO));

        $this->setResponseCode($registration);
        $this->setParams($registration);
        $this->response['data']['registration'] = $this->getMessage();

        return $this;
    }

    private function sendActivationEmail(): Register
    {
        $activationEmail = (new Email(RDTO: $this->RDTO));

        $this->setResponseCode($activationEmail);
        $this->setParams($activationEmail);
        $this->response['data']['existence'] = $this->getMessage();

        return $this;
    }

    private function setResponseCode(object $object): void
    {
        $this->setParams($object);
        if ($this->getResult()){
            $this->response = ['code' => RegisterReturnStatus::SUCCESS->value];
        } else {
            $this->response = ['code' => RegisterReturnStatus::FAILED->value];
        }
    }
}