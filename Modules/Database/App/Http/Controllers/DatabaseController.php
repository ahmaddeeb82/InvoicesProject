<?php

namespace Modules\Database\App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\JsonDatabases;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Database\app\DTOs\DatabaseDTO;
use Modules\Database\App\Http\Requests\DatabaseNameRequest;
use Modules\Database\app\Repositories\DatabaseRepository;
use Modules\Database\app\Services\DatabaseService;

class DatabaseController extends Controller
{
    public function list() {
        
        return (new DatabaseService(new DatabaseRepository()))->list();
    }

    public function setAdmin(DatabaseNameRequest $request) {
        $dto = new DatabaseDTO(
            $request->name
        );

        (new DatabaseService(new DatabaseRepository($dto)))->setDatabaseForAdmin();

        return ApiResponse::apiSendResponse(
            200,
            __('messages.updated')
        );
    }

    public function setUsers(DatabaseNameRequest $request) {
        $dto = new DatabaseDTO(
            $request->name
        );
        
        (new DatabaseService(new DatabaseRepository($dto)))->setDatabaseForUsers();

        return ApiResponse::apiSendResponse(
            200,
            __('messages.updated')
        );
    }

    public function getAdmin() {

        return ApiResponse::apiSendResponse(
            200,
            __('messages.updated'),
            ['name' => JsonDatabases::getAdminDatabase()]
        );
    }

    public function getUsers() {

        return ApiResponse::apiSendResponse(
            200,
            __('messages.updated'),
            ['name' => JsonDatabases::getUsersDatabase()]
        );
    }
  
}
