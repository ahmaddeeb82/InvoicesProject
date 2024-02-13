<?php

namespace Modules\Sales\App\Services;

use Modules\Invoice\App\Models\InvoiceType;
use Modules\Sales\App\Resources\BranchSalesResource;
use Modules\Invoice\App\Models\Invoice;
use Modules\Sales\App\Models\Sales;
use Modules\Sales\App\DTOs\SalesDTO;
use Illuminate\Support\Facades\DB;


 class SalesService{
    public function __construct(){

    }

    public function GetAllBranchesSales()
    {
        $Invoices = Invoice::where('PayType', '1')->get(['Branch', 'Date', 'GUID', 'Total']);
        $InvoiceType = DB::connection('sqlsrv')->table('bu000')
        ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
        ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1') ->take(10)->get();

        $branches = Sales::where('Code', '>', 2)->get(['Name','Number' , 'Code', 'GUID']);

        $totals = [];

        foreach ($branches as $branch) {
            $totals[$branch->GUID] = 0;
        }

        foreach ($Invoices as $Invoice) {
            $totals[$Invoice->Branch] += $Invoice->Total;
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
        // return new BranchSalesResource($salesDTO);
        return $InvoiceType;
        // return $salesDTO;
    }


    public function GetById(SalesDTO $salesDTO)
    {
        $id = $salesDTO->branchGUID;

        $Invoices = Invoice::where('PayType', '1')->get(['Branch', 'Date', 'GUID', 'Total']);

        $branch = Sales::where('GUID' , $id)->get(['Name', 'Code', 'GUID'])->first();
        // dd($branch);
        $totals  = 0;
        foreach($Invoices as $Invoice){
            if($Invoice ->Branch == $id){
                $totals+= $Invoice->Total;
            }
        }
        $result[] = [
            'branch' => $branch->Name,
            'code' => $branch->Code,
            'GUID' => $branch->GUID,
            'total_Sales' => $totals
        ];
        return $result;
    }

    public function GetGreatestBranchSales()
    {
        $sales = $this->GetAllBranchesSales();
        usort($sales, function($a, $b) {
            return $b['total_Sales'] - $a['total_Sales']; // Sort in descending order
        });


        return $sales;
    }

}
