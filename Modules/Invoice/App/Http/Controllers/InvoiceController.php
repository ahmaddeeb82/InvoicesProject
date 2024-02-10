<?php

namespace Modules\Invoice\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Invoice\App\Models\Invoice;


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
    public function create()
    {
        return view('invoice::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('invoice::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('invoice::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
