<?php

namespace Modules\Database\app\DTOs;

class DatabaseDTO
{
    public string $name;

    public function __construct()
    {
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();

        if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
            call_user_func_array(array($this, $method_name), $get_arguments);
        }
    }

    public function __construct1(string $name)
    {
        $this->name = $name;
    }

    
}