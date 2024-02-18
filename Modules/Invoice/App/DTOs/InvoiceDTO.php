<?php

namespace Modules\Invoice\app\DTOs;

class InvoiceDTO
{
    public int $pagination;
    public string $GUID;
    public string $search;
    public $first_date;
    public $last_date;

    public function __construct()
    {
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();

        if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
            call_user_func_array(array($this, $method_name), $get_arguments);
        }
    }

    public function __construct2(int $pagination, string $GUID)
    {
        $this->pagination = $pagination;
        $this->GUID = $GUID;
    }

    public function __construct4(string $GUID, string $search, string $forCons,string $forncons1)
    {
        $this->GUID = $GUID;
        $this->search = $search;
    }

    public function __construct3(string $GUID, $first_date, $last_date)
    {
        $this->GUID = $GUID;
        $this->first_date = $first_date;
        $this->last_date = $last_date;
    }
    
}