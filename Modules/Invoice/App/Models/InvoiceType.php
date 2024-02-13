<?php

namespace Modules\Invoice\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Invoice\Database\factories\InvoiceTypeFactory;

class InvoiceType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

     protected $connection = "sqlsrv";
     protected $table ="bt000";
    protected $fillable = [];


}
