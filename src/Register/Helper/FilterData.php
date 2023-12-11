<?php

namespace App\Register\Helper;

use App\DTO\RegisterDTO;

trait FilterData
{

    public function doFilterData(RegisterDTO $object): RegisterDTO
    {
        $array = [];

        foreach ($object as $key => $value) {
            $array[$key] = trim($value);
        }
        $array = array_map('htmlspecialchars', $array);

        return new RegisterDTO(
            $array['userName'],
            $array['userPassword'],
            $array['userEmail'],
            $array['userEmailRepeat']
        );
    }
}