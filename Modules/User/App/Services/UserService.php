<?php

namespace Modules\User\app\Services;

use Illuminate\Support\Facades\Hash;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\app\Repositories\UserRepository;
use Modules\User\app\Resources\AuthResource;

class UserService {

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createUser(){

        $user = $this->repository->createUser();
        
        $user->assignRole([2]);

        if(count($this->repository->dtoArray['permissions']) != 0) {
            $user->givePermissionTo($this->repository->dtoArray['permissions']);
        }
        
        return new AuthResource([
            'id' => $user->id,
            'token' => $user->createToken('husain')->plainTextToken
        ]);
    }

    public function checkLogin() {
        $user = $this->repository->callLoginUser();

        if(Hash::check($this->repository->dtoArray['password'], $user->password))
        {
            return [
                'code' => 200,
                'message'=> __('messages.loggedin'),
                'data' => new AuthResource([
                    'id' => $user->id,
                    'token' => $user->createToken('husain')->plainTextToken
                ]),
            ];
        }
        else {
            return [
                'code' => 401,
                'message'=> __('auth.password'),
                'data' => [],
            ];
        }
    }
}