<?php

namespace Modules\Sales\App\Services;

use Modules\Invoice\App\Models\InvoiceType;
use Modules\Sales\App\DTOs\SearchDTO;
use Modules\Sales\App\Resources\BranchSalesResource;
use Modules\Invoice\App\Models\Invoice;
use Modules\Sales\App\Models\Sales;
use Modules\Sales\App\DTOs\SalesDTO;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\Sales\App\Respository\SalesRepository;
use Number;


 class SalesService{

    public function __construct(){}

    public function GetAllBranchesSales()
    {
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
                    'number' => $branch->Number,
                    'GUID' => $branch->GUID,
                    'spelled_total' => Number::spell($totals[$branch->GUID] , after:1000 , locale:'ar'),
                    'total_Sales' => $totals[$branch->GUID]
                ];
            }
        }
        return $salesDTO;
    }


    public function GetById(SalesDTO $salesDTO)
    {
        $id = $salesDTO->branchGUID;

        $branch = (new SalesRepository())->getById($id);

        $branch_sales = (new SalesRepository)->getBranchSales($branch);

        $salesDTO = [
            'branch' => $branch->Name,
            'number' => $branch->Number,
            'GUID' => $branch->GUID,
            'spelled_total' => Number::spell($branch_sales , after:1000 , locale:'ar'),
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
    public function GetBranchesSalesBetweenMonths($startDate , $endDate){
        $branches =(new SalesRepository())->getAll();
        $totals = [];

        foreach ($branches as $branch) {
            $totals[$branch->GUID] = (new SalesRepository())->getBranchSalesBetweenMonths($branch,$startDate,$endDate);
        }

        $salesDTO = [];
        foreach ($branches as $branch) {
            if (isset($totals[$branch->GUID])) {
                $salesDTO[] = [
                    'branch' => $branch->Name,
                    'number' => $branch->Number,
                    'GUID' => $branch->GUID,
                    'spelled_total' => Number::spell($totals[$branch->GUID] , after:1000 , locale:'ar'),
                    'total_Sales' => $totals[$branch->GUID]
                ];
            }
        }

        usort($salesDTO, function($a, $b) {
            return $b['total_Sales'] - $a['total_Sales']; // Sort in descending order
        });
        return $salesDTO;
    }

    public function GetAllSalesValue(){

        $value =   (new SalesRepository())->getTotalSalesValue();
            $data[] =[
            'spelled_total' => Number::spell($value , after:1000 , locale:'ar'),
            'total'=>  $value
            ];
        return $data;
    }

    public function GetSalesValueForMonth()
    {
        $value = (new SalesRepository())->getTotalSalesValueAtMonth();
        $data = [];
        for($i=1 ; $i<13 ;$i++ )
        {
        $data []=[
            'month' => $i,
            // 'spelled_total' => Number::spell($value[$i] , after:1000 , locale:'ar'),
            'total'=>   $value[$i]

            ];
        }
        return $data;
    }

    public function GetBranchSalesValueBetweenMonths($startDate , $endDate){
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);


        $value = (new SalesRepository())->getTotalSalesValueAtBetweenMonths($start , $end);
        $data[] =[
            'spelled_total' => Number::spell($value , after:1000 , locale:'ar'),
              'total'=>   $value
            ];
        return $data;
    }

   public function SearchForBranch($searchDTO)
    {
        $NameResult = (new SalesRepository())->searchByName($searchDTO);

        $NumberResult = null;

        if(is_numeric($searchDTO))
                $NumberResult =  (new SalesRepository())->searchByNumber($searchDTO);

        $results = [];

        if($NameResult != null){
            $results['Name results']= $NameResult;
            // dd($NumberResult);
        }
        else
             $results['Name results']= [];
        if($NumberResult != null){
            $results['Number results']=$NumberResult;
        }
        else
              $results['Number results']= [];
        return $results;
    }

    public function GetNumOfBranches()
    {
        $result = (new SalesRepository)->GetNumOfBranches();
        return $result;
    }

}
