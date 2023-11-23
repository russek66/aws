<?php

namespace App\Core;

use App\Core\Session\SessionUsage;

class Csrf
{
    use SessionUsage;
    use Request {
        SessionUsage::get insteadof Request;
        Request::get as getRequest;
    }

    public function generateToken(): ?string
    {
        $maxTime    = 60 * 60 * 24;
        $storedTime = $this->get(key:'csrf_token_time');
        $csrfToken  = $this->get(key:'csrf_token');

        if ($maxTime + $storedTime <= time() || empty($csrfToken)) {
            $this->set(key:'csrf_token', param: bin2hex(random_bytes(50)));
            $this->set(key:'csrf_token_time', param: time());
        }

        return $this->get(key:'csrf_token');
    }

    public function validateToken(): bool
    {
        $token = $this->post('csrf_token');
        return $token === $this->get(key:'csrf_token') && !empty($token);
    }
}