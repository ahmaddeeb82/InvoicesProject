<?php
    namespace Modules\Sales\App\DTOs;


class SalesDTO{

    public $branchName;
    public $branchCode;
    public $branchGUID;
    public $totalInvoices;

    public $searchParameter;

    public function __construct()
    {
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();

        if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
            call_user_func_array(array($this, $method_name), $get_arguments);
        }
    }

    public function __construct1($id)
    {
        $this->branchGUID = $id;
    }


    public function __construct2( $parameter ,$id = 0)
    {
        $this->searchParameter = $parameter;
    }

    public function __construct3($branchName , $branchCode , $branchGUID)
    {
        $this->branchName = $branchName;
        $this->branchGUID = $branchGUID;
        $this->branchCode = $branchCode;
    }

    public function __construct4($branchName , $branchCode , $branchGUID , $totalInvoices)
    {
        $this->branchName = $branchName;
        $this->branchGUID = $branchGUID;
        $this->branchCode = $branchCode;
        $this->totalInvoices= $totalInvoices;
    }

}
