<?php

namespace Modules\Invoice\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class InvoiceSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'GUID' => $this->GUID,
            'Number' => $this->Number,
            'Total' => $this->Total,
            'Spelled Total' => Number::spell($this->Total, locale:'ar'),
            'Date' => $this->Date,
            'Branch' => $this->Branch,
        ];
    }
}
