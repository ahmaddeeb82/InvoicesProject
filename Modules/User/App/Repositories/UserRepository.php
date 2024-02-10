<?php

namespace Modules\User\app\Repositories;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\app\Models\User;

class UserRepository
{
    public $dtoArray;

    public function __construct()
    {
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();

        if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
            call_user_func_array(array($this, $method_name), $get_arguments);
        }
    }

    public function __construct0(){}

    public function __construct1(UserDTO $dto)
    {
        $this->dtoArray = json_decode(json_encode($dto), true);
    }

    public function createUser()
    {
        $this->dtoArray['password'] = Crypt::encryptString($this->dtoArray['password']);
        return User::create([
            'username' => $this->dtoArray['username'],
            'password' => $this->dtoArray['password'],
            'name' => $this->dtoArray['name'],
            'role' => $this->dtoArray['role'],
        ]);
    }

    public function callLoginUser()
    {
        return User::where('username', $this->dtoArray['username'])->first();
    }

    public function getUserByID()
    {
        return User::where('id', $this->dtoArray['id'])->first();
    }

    public function  updateProfile()
    {
        $this->dtoArray['password'] = Crypt::encryptString($this->dtoArray['password']);
        
        $user = $this->getUserByID();
        $user->update([
            'username' => $this->dtoArray['username'],
            'password' => $this->dtoArray['password'],
            'name' => $this->dtoArray['name'],
        ]);
        return $user;
    }

    public function getAllUSers() {
        return User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'User')->toArray()
        );
    }

    public function  deleteUser() {
        $user = $this->getUserByID();

        $user->delete();
    }
    
}