<?php

namespace Modules\User\app\Repositories;

use Illuminate\Support\Facades\Hash;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\app\Models\User;

class UserRepository
{
    public $dtoArray;

    public function __construct(UserDTO $dto)
    {
        $this->dtoArray = json_decode(json_encode($dto), true);
    }

    public function createUser()
    {
        $this->dtoArray['password'] = Hash::make($this->dtoArray['password']);
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
}