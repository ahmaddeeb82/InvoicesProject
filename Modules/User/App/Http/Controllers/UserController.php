<?php

namespace Modules\User\app\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\app\Http\Requests\LoginRequest;
use Modules\User\app\Http\Requests\RegisterReauest;
use Modules\User\app\Repositories\UserRepository;
use Modules\User\app\Services\UserService;

class UserController extends Controller
{

    public function addUser(RegisterReauest $request) {
        
        $userDto = new UserDTO(
            $request->name,
            $request->username,
            $request->password,
            $request->permissions,
        );

        return ApiResponse::apiSendResponse(
            201,
            __('messages.registered'),
            (new UserService(new UserRepository($userDto)))->createUser()
        );
        
    }

    public function login(LoginRequest $request) {
        
        $userDto = new UserDTO(
            $request->username,
            $request->password,
        );

        $response = (new UserService(new UserRepository($userDto)))->checkLogin();

        return ApiResponse::apiSendResponse(
            $response['code'],
            $response['message'],
            $response['data']
        );

    }
}
