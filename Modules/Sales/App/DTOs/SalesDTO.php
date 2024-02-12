<?php
namespace Modules\Sales\App\DTOs;

use Ramsey\Uuid\Guid\Guid;

class SalesDTO{

    public $branchName;
    public $branchCode;
    public $branchGUID;
    public $totalInvoices;

    public function __construct($id)
    {
        $this->branchGUID = $id;
    }

}
