<?php

namespace Modules\Invoice\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Invoice\app\DTOs\InvoiceDTO;
use Modules\Invoice\App\Exports\InvoicesExport;
use Modules\Invoice\App\Http\Requests\GetInvoiceExportRequest;
use Modules\Invoice\App\Models\Invoice;
use Modules\Invoice\app\Repositories\InvoiceRepository;
use Modules\Invoice\App\resources\InvoiceResource;
use Modules\Invoice\app\Services\InvoiceService;
use stdClass;

class InvoiceController extends Controller
{

    public function list(Request $request) {
        $dto = new InvoiceDTO(
            $request->page,
            $request->GUID,
        );
        return (new InvoiceService(new InvoiceRepository($dto)))->list();
    }

    public function search(Request $request) {
        $dto = new InvoiceDTO(
            $request->GUID,
            $request->search,
            1,1
        );
        return (new InvoiceService(new InvoiceRepository($dto)))->search();
    }

    public function export(Request $request) 
    {
        $dto = new InvoiceDTO(
            $request->GUID,
            $request->first_date,
            $request->last_date,
        );
        $invoice_export = new InvoicesExport;
        $invoice_export->invoices = (new InvoiceRepository($dto))->GetAllExportInvoices();
        
        return Excel::download($invoice_export, 'invoices_'.now()->format('Y-m-d').'.xlsx');
    }

    public function exportPDF(Request $request) 
    {
        $dto = new InvoiceDTO(
            $request->GUID,
            $request->first_date,
            $request->last_date,
        );
        
        $pdf = SnappyPdf::loadView('invoicespdf', ['invoices' => (new InvoiceRepository($dto))->GetAllExportInvoices()]);

        return $pdf->download('invoices_'.now()->format('Y-m-d').'.pdf');
    }
}
