<?php

namespace App\Core\View;

use App\Core\Config;

class View
{
    use Config;

    private array $properties = [];

    public function __set(string $name, mixed $value): void
    {
        $this->properties[$name] = $value;
    }

    public function __get(string $name): mixed
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        return null;
    }

    public function render(string $filename, mixed $data = null): void
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->properties[$key] = $value;
            }
        }
        $filenamePath = $this->get('PATH_VIEW') . $filename;

        require $filenamePath .'.php';
    }

    public function renderJSON($code = 200, $data = null): string
    {
        header_remove();
        http_response_code($code);
        header("Cache-Control: no-transform,public,max-age=300,s-max-age=900");
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );

        header('Status: '.$status[$code]);

        return json_encode([
            'status' => $code < 300, // success or not?
            'data' => $data
        ]);

    }

}