<?php

namespace Modules\Sales\App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Invoice\App\resources\InvoiceResource;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SalesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use RegistersEventListeners;

    public $sales;


    public function view(): View
    {
        $sales = $this->sales;


        return view('sales', [
            'sales' => $sales
        ]);
    }

}
