<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Modules\Sales\App\Models\Sales;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('guid_format', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}$/', $value);
        });

        Validator::extend('unique_guid', function ($attribute, $value, $parameters, $validator) {
            $specificGuid = $parameters[0]; // Retrieve the specific GUID from the validation rule parameters
            return Sales::where('GUID', $value)->where('GUID', '=', $specificGuid)->doesntExist();
        });
    }
}
