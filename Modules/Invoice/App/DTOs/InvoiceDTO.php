<?php

namespace Modules\Invoice\app\DTOs;

class InvoiceDTO
{
    public int $pagination;
    public string $GUID;
    public string $search;

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

    public function __construct3(int $pagination, string $GUID, string $search)
    {
        $this->pagination = $pagination;
        $this->GUID = $GUID;
        $this->search = $search;
    }

    
}