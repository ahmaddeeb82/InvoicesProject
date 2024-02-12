<?php

namespace Modules\Sales\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class BranchSalesResource extends JsonResource{
    public function toArray($request){
        // return [
        //     'branch' => $this['name'],
        //     'code' => $this->Code,
        //     'GUID' => $this->GUID,
        //     'total_Sales' => $this->totals
        // ];
    }
}
