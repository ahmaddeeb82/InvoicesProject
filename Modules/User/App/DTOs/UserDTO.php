<?php

namespace Modules\User\app\DTOs;

class UserDTO
{
    public string $name;
    public string $username;
    public string $password;
    public string $role;
    public $permissions;

    public function __construct()
    {
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();

        if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
            call_user_func_array(array($this, $method_name), $get_arguments);
        }
    }

    public function __construct4(string $name, string $username, string $password, $permissions)
    {
        $this->name =  $name;
        $this->username = $username;
        $this->password = $password;
        $this->role = 'user';
        $this->permissions = $permissions;
    }


    public function __construct2(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}