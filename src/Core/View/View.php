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

    public function renderJSON(mixed $data): void
    {
        header("Content-Type: application/json");
        json_encode($data);
    }

}