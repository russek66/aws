<?php

namespace App\Core\Session;

use App\Login\LoginSocialValidate;

class Session
{

    public function __construct()
    {
        $this->init();
    }

    public function init(): void
    {
        if (session_id() == '') {
            session_start();
        }
    }

    public function destroy(): void
    {
        session_destroy();
    }
}