<?php

namespace App\Helpers;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Crypt;

class JsonDatabases {

    public static $connection_name;

    public static function getAdminDatabase() {
        $filePath = base_path('Modules\Database\connections.json');
        $fileContent = file_get_contents($filePath);
        $josnContent = json_decode($fileContent, true);
        return $josnContent['admin'];
    }

    public static function getUsersDatabase() {
        $filePath = base_path('Modules\Database\connections.json');
        $fileContent = file_get_contents($filePath);
        $josnContent = json_decode($fileContent, true);
        return $josnContent['users'];
    }

    public static function getDatabaseHost() {
        $filePath = base_path('Modules\Database\connections.json');
        $fileContent = file_get_contents($filePath);
        $josnContent = json_decode($fileContent, true);
        return $josnContent['host'];
    }
}