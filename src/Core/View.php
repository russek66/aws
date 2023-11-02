<?php

namespace App\Core;

class View
{
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
    }

    public function render(string $filename, mixed $data = null):void
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->properties[$key] = $value;
            }
        }
        $filenamePath = Config::get('PATH_VIEW') . $filename;

        require $filenamePath .'.php';
    }

}