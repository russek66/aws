<?php

declare(strict_types = 1);

namespace App\Enum;

enum RegisterAttemptStatus: string
{
    case SUCCESS = "FEEDBACK_REGISTRATION_SUCCESS";
    case FAILED = "FEEDBACK_REGISTRATION_FAILED";
    case FAILED_USER = "FEEDBACK_INVALID_USERNAME_FORMAT";
    case FAILED_EMPTY_EMAIL = "FEEDBACK_EMPTY_EMAIL";
    case FAILED_EMAIL_REPEAT_WRONG = "FEEDBACK_EMAIL_REPEAT_WRONG";
    case FAILED_INVALID_EMAIL_FORMAT = "FEEDBACK_INVALID_EMAIL_FORMAT";
    case FAILED_EMPTY_PASSWORD = "FEEDBACK_EMPTY_PASSWORD";
    case FAILED_PASSWORD_REPEAT_WRONG = "FEEDBACK_PASSWORD_REPEAT_WRONG";
    case FAILED_INVALID_PASSWORD_FORMAT = "FEEDBACK_INVALID_PASSWORD_FORMAT";
    case FAILED_USER_EXIST = "FEEDBACK_USER_EXIST";
    case FAILED_EMAIL_EXIST = "FEEDBACK_EMAIL_EXIST";
}