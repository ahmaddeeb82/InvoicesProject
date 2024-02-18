<?php

namespace Modules\Invoice\App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Invoice\App\resources\InvoiceResource;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class InvoicesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use RegistersEventListeners;

    public $invoices;


    public function view(): View
    {
        $invoices = $this->invoices;


        return view('invoices', [
            'invoices' => $invoices
        ]);
    }

}
