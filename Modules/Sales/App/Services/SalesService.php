<?php

namespace Modules\Sales\App\Services;

use Modules\Invoice\App\Models\InvoiceType;
use Modules\Sales\App\Resources\BranchSalesResource;
use Modules\Invoice\App\Models\Invoice;
use Modules\Sales\App\Models\Sales;
use Modules\Sales\App\DTOs\SalesDTO;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\Sales\App\Respository\SalesRepository;


 class SalesService{

    public function __construct(){
    }

    public function GetAllBranchesSales()
    {
        // $Invoices = Invoice::where('PayType', '1')->get(['Branch', 'Date', 'GUID', 'Total']);
        // $InvoiceType = DB::connection('sqlsrv')->table('bu000')
        // ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
        // ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')->get();

        // $branches = Sales::where('Code', '>', 2)->get(['Name','Number' , 'Code', 'GUID']);

        // $totals = [];

        // foreach ($branches as $branch) {
        //     $totals[$branch->GUID] = DB::connection('sqlsrv')->table('bu000')
        //     ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
        //     ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')
        //     ->where('bu000.Branch' ,$branch->GUID)->sum('Total');
        // }

        // foreach ($InvoiceType as $Invoice) {
        //     $totals[$Invoice->Branch] += $Invoice->Total;
        // }

        // $salesDTO = [];

        // foreach ($branches as $branch) {
        //     if (isset($totals[$branch->GUID])) {
        //         $salesDTO[] = [
        //             'branch' => $branch->Name,
        //             'code' => $branch->Code,
        //             'GUID' => $branch->GUID,
        //             'total_Sales' => $totals[$branch->GUID]
        //         ];
        //     }
        // }
        $branches =(new SalesRepository())->getAll();
        $totals = [];

        foreach ($branches as $branch) {
            $totals[$branch->GUID] = (new SalesRepository())->getBranchSales($branch);
        }
        $salesDTO = [];
        foreach ($branches as $branch) {
            if (isset($totals[$branch->GUID])) {
                $salesDTO[] = [
                    'branch' => $branch->Name,
                    'code' => $branch->Code,
                    'GUID' => $branch->GUID,
                    'total_Sales' => $totals[$branch->GUID]
                ];
            }
        }
        return $salesDTO;
    }


    public function GetById(SalesDTO $salesDTO)
    {
        $id = $salesDTO->branchGUID;
        // $Invoices = Invoice::where('PayType', '1')->get(['Branch', 'Date', 'GUID', 'Total']);

        // $InvoiceType = DB::connection('sqlsrv')->table('bu000')
        // ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
        // ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')->get();

        // $branch = Sales::where('GUID' , $id)->get(['Name', 'Code', 'GUID'])->first();
        // // $totals  = 0;
        // // foreach($InvoiceType as $Invoice){
        // //     if($Invoice ->Branch == $id){
        // //         $totals+= $Invoice->Total;
        // //     }
        // // }

        // $totals =  DB::connection('sqlsrv')->table('bu000')
        // ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
        // ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')
        // ->where('bu000.Branch' ,$branch->GUID)->sum('Total');

        // $result[] = [
        //     'branch' => $branch->Name,
        //     'code' => $branch->Code,
        //     'GUID' => $branch->GUID,
        //     'total_Sales' => $totals
        // ];

        $branch = (new SalesRepository())->getById($id);

        $branch_sales = (new SalesRepository)->getBranchSales($branch);

        $salesDTO = [
            'branch' => $branch->branchName,
            'code' => $branch->branchCode,
            'GUID' => $branch->branchGUID,
            'total_Sales' => $branch_sales
        ];

        return $salesDTO;
    }

    public function GetGreatestBranchSales()
    {
        $sales = $this->GetAllBranchesSales();
        usort($sales, function($a, $b) {
            return $b['total_Sales'] - $a['total_Sales']; // Sort in descending order
        });
        return $sales;
    }

    public function GetAllSalesValue(){
        // $InvoiceType = DB::connection('sqlsrv')->table('bu000')
        // ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
        // ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')->sum('Total');
        // return $InvoiceType;
        return (new SalesRepository())->getTotalSalesValue();
    }

    public function GetSalesValueForMonth($date){

        if($date == null){
            $selected_month = Carbon::now()->format('Y-m-d'); // Get the current date in 'Y-m-d' format
        }
        else{
            $selected_month = Carbon::parse($date);
        }
        return (new SalesRepository())->getTotalSalesValueAtMonth($selected_month);
    }



}
