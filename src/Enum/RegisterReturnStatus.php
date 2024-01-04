<?php

declare(strict_types=1);

namespace App\Enum;

enum RegisterReturnStatus: string
{
    case SUCCESS = "200";
    case FAILED = "500";
}