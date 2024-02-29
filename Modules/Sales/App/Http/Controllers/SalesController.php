<?php

namespace Modules\Sales\App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Invoice\App\Models\Invoice;
use Modules\Sales\App\Http\Requests\GetBranchSaleRequest;
use Modules\Sales\App\Models\Sales;
use Modules\Sales\App\Services\SalesService;
use Modules\Sales\App\DTOs\SalesDTO;
use Modules\Sales\App\Exports\SalesExport;

class SalesController extends Controller
{
//    public SalesService $salesService;

    public function index()
    {

        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new SalesService)-> GetAllBranchesSales()
        );
    }

    public function show(GetBranchSaleRequest $request)
    {
         $salesDTO = new SalesDTO(
            $request->id,
         );

       return ApiResponse::apiSendResponse(
        200,
        __('messages.retrieved'),
        (new SalesService)->GetById($salesDTO)
       );
    }

    public function SortByBranchSales(){
        $result =  (new SalesService)->GetGreatestBranchSales();

        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
           $result
        );
    }

    public function GetGreatestBranchSales(){
        $result =  (new SalesService)->GetGreatestBranchSales();

        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
           $result[0]
        );
    }

    public function GetBranchsSales(){
        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new SalesService)->GetAllSalesValue()
        );
    }

    public function GetSalesValueForMonth(){
        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new SalesService)->GetSalesValueForMonth()
        );
    }

    public function searchForBranch(Request $request)
    {
        $data = $request->param;

        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new SalesService)->SearchForBranch($data)
        );

    }


    public function GetSalesValueBetweenMonths(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request-> end_date;
        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new SalesService)->GetBranchSalesValueBetweenMonths($startDate , $endDate)
        );
    }

    public function GetBranchesSalesBetweenMonths(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request-> end_date;

        $sales = [ (new SalesService)->GetBranchesSalesBetweenMonths($startDate , $endDate),
        (new SalesService)->GetBranchSalesValueBetweenMonths($startDate , $endDate)
        ];

        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            $sales
        );
    }


    public function GetBranchesSalesBetweenMonthsForExcel(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request-> end_date;

        $sales_export = new SalesExport;
        $sales_export->sales = [ (new SalesService)->GetBranchesSalesBetweenMonths($startDate , $endDate),
        (new SalesService)->GetBranchSalesValueBetweenMonths($startDate , $endDate)
        ];

        return Excel::download($sales_export, 'sales_'.now()->format('Y-m-d').'.xlsx');

    }

    public function GetBranchesSalesBetweenMonthsForPDF(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request-> end_date;

        $pdf = SnappyPdf::loadView('salespdf', ['sales' => [ (new SalesService)->GetBranchesSalesBetweenMonths($startDate , $endDate),
        (new SalesService)->GetBranchSalesValueBetweenMonths($startDate , $endDate)
        ]]);

        return $pdf->download('sales_'.now()->format('Y-m-d').'.pdf');

    }

    public function GetNumOfBranches()
    {
        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new SalesService)->GetNumOfBranches()
        );
    }


}
