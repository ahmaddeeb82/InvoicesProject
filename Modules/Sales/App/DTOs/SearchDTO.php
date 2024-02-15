<?php

namespace Modules\Sales\App\DTOs;

class SearchDTO{
    public $parameter;

    public function __construct($param){
        $this->parameter = $param;
    }
}
