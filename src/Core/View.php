<?php

namespace App\Core;

class View
{
    public function render(string $filename, mixed $data = null):void
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
        $filenamePath = Config::get('PATH_VIEW') . $filename;

        require $filenamePath .'.php';
    }

}