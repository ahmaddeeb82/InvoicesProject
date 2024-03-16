<?php

namespace Modules\User\app\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\app\Repositories\UserRepository;
use Modules\User\App\resources\AllUserResource;
use Modules\User\app\Resources\AuthResource;
use Modules\User\App\resources\UserResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserService {

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createUser() {

        $user = $this->repository->createUser();

        $user->assignRole([2]);

        if(count($this->repository->dtoArray['permissions']) != 0) {
            $user->givePermissionTo($this->repository->dtoArray['permissions']);
        }

    }

    public function checkLogin() {
        $user = $this->repository->callLoginUser();

        if($this->repository->dtoArray['password'] == Crypt::decryptString($user->password))
        {
            return [
                'code' => 200,
                'message'=> __('messages.loggedin'),
                'data' => new AuthResource([
                    'id' => $user->id,
                    'token' => $user->createToken('husain')->plainTextToken,
                    'isAdmin' => $user->hasPermissionTo('admin-permession'),
                    'hasExcel' => $user->hasPermissionTo('export-excel'),
                    'hasPdf' => $user->hasPermissionTo('export-pdf'),
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

    public function updateUser() {
        $user = $this->repository->updateProfile();

        $user->tokens()->delete();

        if(count($this->repository->dtoArray['permissions']) != 0) {
            $user->syncPermissions($this->repository->dtoArray['permissions']);
        } else {
            $permissions = $user->getAllPermissions();
            $user->revokePermissionTo($permissions);
        }
    }

    public function listUsers() {
        $users = $this->repository->getAllUSers();

        return ['Users_Count' => count($users), 'Users' => AllUserResource::collection($users)];
    }

    public function getUSerById() {
        $user = $this->repository->getUserByID();

        return  new UserResource($user);
    }

    public function  deleteUser() {
        $this->repository->deleteUser();
    }

    public function deleteToken() {
        $user = auth()->user();

        $user->currentAccessToken()->delete();

        request()->session()->invalidate();
        $sessionFiles = glob(storage_path('framework/sessions') . '/*');
        foreach ($sessionFiles as $file) {
            if (is_file($file)) {
                unlink($file); // Delete individual session files
            }
        }
                }

    public function getCurrentUser() {
        $user = auth()->user();

        return  new UserResource($user);
    }
}
