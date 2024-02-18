<?php

namespace Modules\Database\app\Repositories;

use App\Helpers\JsonDatabases;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Database\app\DTOs\DatabaseDTO;
use Modules\Invoice\app\DTOs\InvoiceDTO;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\app\Models\User;

class DatabaseRepository
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

    public function __construct1(DatabaseDTO $dto)
    {
        $this->dtoArray = json_decode(json_encode($dto), true);
    }

    public function getAllDatabases() {
        return DB::select("select [name] as [database_name] from sys.databases 
        where 
            case when state_desc = 'ONLINE' 
                then object_id(quotename([name]) + '.[dbo].[bu000]', 'U') 
            end is not null
        order by 1");
    }

    public function getCurrentDatabase() {
        return DB::connection(JsonDatabases::$connection_name)->select("select DB_NAME()");
    }

    
}