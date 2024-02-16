<?php

namespace Modules\Invoice\app\Repositories;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Invoice\app\DTOs\InvoiceDTO;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\app\Models\User;

class InvoiceRepository
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

    public function __construct1(InvoiceDTO $dto)
    {
        $this->dtoArray = json_decode(json_encode($dto), true);
    }

    public function GetAllInvoices() {
    return DB::connection('sqlsrv_second')->select("SELECT *
        FROM (
            SELECT [bu000].[Number],[bu000].[Date],[bu000].[Total],[bu000].[Branch]
            ,[bu000].[GUID],[bu000].[TypeGUID], [bt000].[BillType],
                 ROW_NUMBER() OVER (ORDER BY ([Date])) AS RowNumber
          FROM [bu000]
          INNER JOIN [bt000] ON [bu000].[TypeGUID] = [bt000].[GUID]
          WHERE [BillType] = 1
          AND [Branch] = :branch
        ) AS PaginatedData
        WHERE RowNumber BETWEEN :pagination_first AND :pagination_last",
        [
            'pagination_first' => ($this->dtoArray['pagination'] * 20)+1,
            'pagination_last' => ($this->dtoArray['pagination'] + 1) * 20,
            'branch' => $this->dtoArray['GUID']
        ]);
    }

    public function getInvoicesCount() {
        return DB::connection('sqlsrv_second')->select("SELECT COUNT(*) AS FilteredCount
        FROM [bu000]
          INNER JOIN [bt000] ON [bu000].[TypeGUID] = [bt000].[GUID]
          WHERE [BillType] = 1
          AND [Branch] = :branch",['branch' => $this->dtoArray['GUID']]);
    }

    public function searchInvoices() {
        return DB::connection('sqlsrv_second')->select("SELECT * FROM (SELECT [bu000].*, [bt000].[BillType]
        From [bu000]
          INNER JOIN [bt000] ON [bu000].[TypeGUID] = [bt000].[GUID]
          WHERE [BillType] = 1
          AND [Branch] = :branch
          ) AS Ahmad WHERE [Number] like :q Order By [Date]"
          ,['branch' => $this->dtoArray['GUID'], 'q'=> '%'.$this->dtoArray['search'].'%']);
    }
    
}