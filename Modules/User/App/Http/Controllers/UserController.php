<?php

namespace Modules\User\app\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\app\Http\Requests\EditProfileRequest;
use Modules\User\app\Http\Requests\LoginRequest;
use Modules\User\app\Http\Requests\RegisterReauest;
use Modules\User\app\Http\Requests\GetUserRequest;
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

        (new UserService(new UserRepository($userDto)))->createUser();

        return ApiResponse::apiSendResponse(
            201,
            __('messages.registered'),
        );

    }

    public function login(LoginRequest $request) {

        $userDto = new UserDTO(
            $request->username,
            $request->password,
        );

        //return $request->header('Cookie');
        $response = (new UserService(new UserRepository($userDto)))->checkLogin();

        //$response['data']['session_id'] = $request->header('Cookie');

        return ApiResponse::apiSendResponse(
            $response['code'],
            $response['message'],
            $response['data']
        );
    }

    public function updateUser(EditProfileRequest $request) {

        $userDto = new UserDTO(
            $request->id,
            $request->name,
            $request->username,
            $request->password,
            $request->permissions,
        );

        (new UserService(new UserRepository($userDto)))->updateUser();

        return ApiResponse::apiSendResponse(
            200,
            __('messages.updated'),
        );
    }

    public function listUsers() {
        return  ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new UserService(new UserRepository()))->listUsers()
        );
    }

    public function getUser(GetUserRequest $request) {

        $userDto = new UserDTO(
            $request->id,
        );

        return  ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new UserService(new UserRepository($userDto)))->getUSerById()
        );
    }

    public function deleteUser(GetUserRequest $request) {
        $userDto = new UserDTO(
            $request->id,
        );

        (new UserService(new UserRepository($userDto)))->deleteUser();

        return ApiResponse::apiSendResponse(
            200,
            __('messages.deleted'),
        );
    }

    public function logout() {


        (new UserService(new UserRepository()))->deleteToken();

        return ApiResponse::apiSendResponse(
            200,
            __('messages.loggedout'),
        );
    }

    public function getCurrentUser() {
        return  ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new UserService(new UserRepository()))->getCurrentUser()
        );
    }
}
