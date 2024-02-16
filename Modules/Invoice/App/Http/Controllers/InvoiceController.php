<?php

namespace Modules\Invoice\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Invoice\app\DTOs\InvoiceDTO;
use Modules\Invoice\App\Models\Invoice;
use Modules\Invoice\app\Repositories\InvoiceRepository;
use Modules\Invoice\app\Services\InvoiceService;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // for($i=20 ; $i<Invoice::all()->count();$i+=20){
            $data = Invoice::where('PayType', '1')->paginate(20 , ['Branch', 'Date', 'GUID', 'Total']);

            $paginationInfo = [
                'current_page' => $data->currentPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'next_page_url' => $data->nextPageUrl(),
                'prev_page_url' => $data->previousPageUrl(),
            ];

            return response()->json([
                'data' => $data->items(),
                'pagination' => $paginationInfo
            ]);

        // return response()->json($data);


    }

    /**
     * Show the form for creating a new resource.
     */
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
            1
        );
        return (new InvoiceService(new InvoiceRepository($dto)))->search();
    }
}
