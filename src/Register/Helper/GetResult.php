<?php

namespace App\Register\Helper;

use App\Core\Text;
use App\Enum\RegisterAttemptStatus;
use ReflectionClass;

trait GetResult
{
    use Text {
        Text::get as getText;
    }

    private bool $result;
    private mixed $resultMessage;

    public function setParams(object $object): void
    {
        $reflectionClass = new ReflectionClass($object);
        $this->result = $reflectionClass->getProperty('result')->getValue();
        $this->resultMessage = $reflectionClass->getProperty('resultMessage')->getValue();
    }

    public function getResult(): bool
    {
        return $this->result;
    }

    public function getMessage(): array
    {
        if($this->resultMessage === RegisterAttemptStatus::SUCCESS) {
            $msg = [
                'status'    => RegisterAttemptStatus::SUCCESS->name,
                'msg'       => $this->getText('registration',  RegisterAttemptStatus::SUCCESS->value)
            ];
        } else {
            $msg = [
                'status'    => RegisterAttemptStatus::FAILED->name,
                'msg'       => $this->getText('registration',  $this->resultMessage->value)
            ];
        }
        return $msg;
    }
}