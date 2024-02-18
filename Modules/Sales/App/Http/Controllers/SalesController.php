<?php

namespace Modules\Sales\App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Invoice\App\Models\Invoice;
use Modules\Sales\App\Http\Requests\GetBranchSaleRequest;
use Modules\Sales\App\Models\Sales;
use Modules\Sales\App\Services\SalesService;
use Modules\Sales\App\DTOs\SalesDTO;
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

    //    $paginationInfo = [
    //     'current_page' => $data->currentPage(),
    //     'total' => $data->total(),
    //     'per_page' => $data->perPage(),
    //     'last_page' => $data->lastPage(),
    //     'next_page_url' => $data->nextPageUrl(),
    //     'prev_page_url' => $data->previousPageUrl(),
    // ];

    // return response()->json([
    //     'data' => $data->items(),
    //     'pagination' => $paginationInfo
    // ]);
    // return response()->json($result);
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

    public function GetBranchsSales(){
        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new SalesService)->GetAllSalesValue()
        );
    }

    public function GetSalesValueForMonth(Request $request){
        $date = $request->date;
        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            (new SalesService)->GetSalesValueForMonth($date)
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
        $data =  [ (new SalesService)->GetBranchesSalesBetweenMonths($startDate , $endDate),
                 (new SalesService)->GetBranchSalesValueBetweenMonths($startDate , $endDate)
    ];
        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            $data
        );
    }


}
