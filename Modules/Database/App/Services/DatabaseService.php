<?php

namespace Modules\Database\app\Services;

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Modules\Database\app\Repositories\DatabaseRepository;
use Modules\Invoice\app\Repositories\InvoiceRepository;
use Modules\Invoice\App\resources\InvoiceResource;
use Modules\Invoice\App\resources\InvoiceSearchResource;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\App\resources\AllUserResource;
use Modules\User\app\Resources\AuthResource;
use Modules\User\App\resources\UserResource;

class DatabaseService {

    protected $repository;

    public function __construct(DatabaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list() {

        $databases = $this->repository->getAllDatabases();
        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            $databases
        );
    }

    public function setDatabaseForAdmin() {
        $database_name = $this->repository->dtoArray['name'];
        $filePath = base_path('Modules\Database\connections.json');
        $fileContent = file_get_contents($filePath);
        $josnContent = json_decode($fileContent, true);
        $josnContent['admin'] = $database_name;
        $newJsonContent = json_encode($josnContent);
        file_put_contents($filePath,$newJsonContent);
    }

    public function setDatabaseForUsers() {
        $database_name = $this->repository->dtoArray['name'];
        $filePath = base_path('Modules\Database\connections.json');
        $fileContent = file_get_contents($filePath);
        $josnContent = json_decode($fileContent, true);
        $josnContent['users'] = $database_name;
        $newJsonContent = json_encode($josnContent);
        file_put_contents($filePath,$newJsonContent);
    }

}