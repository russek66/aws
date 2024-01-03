<?php

namespace App\Core;

trait Text
{

    use Config {
        Config::get as getConfig;
    }

    private mixed $texts = null;

    public function get(string $file, mixed $key)
    {

        if (! $this->texts) {
            $this->texts = require($this->getConfig('TEXTS_PATH') . ucwords($file) . 'Texts.php');
        }
        if (! array_key_exists($key, $this->texts)) {
            return null;
        }

        return $this->texts[$key];
    }
}
