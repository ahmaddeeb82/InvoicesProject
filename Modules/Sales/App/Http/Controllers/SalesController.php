<?php

namespace Modules\Sales\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Sales\App\Models\Sales;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $data = Sales::where('Code', '>' , 2 )->paginate(20 , ['Name', 'Code', 'GUID']);
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
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales::create');
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
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('sales::edit');
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
