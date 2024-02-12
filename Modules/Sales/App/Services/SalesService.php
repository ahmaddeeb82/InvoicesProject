<?php

namespace Modules\Sales\App\Services;

use Modules\Sales\App\Resources\BranchSalesResource;
use Modules\Invoice\App\Models\Invoice;
use Modules\Sales\App\Models\Sales;
use Modules\Sales\App\DTOs\SalesDTO;

 class SalesService{
    public function __construct(){

    }

    public function GetAllBranchesSales()
    {
        $Invoices = Invoice::where('PayType', '1')->get(['Branch', 'Date', 'GUID', 'Total']);

        $branches = Sales::where('Code', '>', 2)->get(['Name', 'Code', 'GUID']);

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
        return $salesDTO;
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
