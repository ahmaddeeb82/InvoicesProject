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

    public function __construct(){
    }

    public function GetAllBranchesSales()
    {
        $branches =(new SalesRepository())->getAll();
        $totals = [];

        foreach ($branches as $branch) {
            $totals[$branch->GUID] = (new SalesRepository())->getBranchSales($branch);
        }

        $spelledNumber = Number::spell(55000, after:5000);

        $salesDTO = [];
        foreach ($branches as $branch) {
            if (isset($totals[$branch->GUID])) {
                $salesDTO[] = [
                    'branch' => $branch->Name,
                    'code' => $branch->Code,
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
            'code' => $branch->Code,
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

    public function GetAllSalesValue(){

        $value =   (new SalesRepository())->getTotalSalesValue();

            $data[] =[
            'spelled_total' => Number::spell($value , after:1000 , locale:'ar'),
            'total'=>  $value
            ];
        return $data;
    }

    public function GetSalesValueForMonth($date){

        if($date == null){
            $selected_month = Carbon::now()->format('Y-m-d'); // Get the current date in 'Y-m-d' format
        }
        else{
            $selected_month = Carbon::parse($date);
        }

        $value = (new SalesRepository())->getTotalSalesValueAtMonth($selected_month);
        $data[] =[
            'spelled_total' => Number::spell($value , after:1000 , locale:'ar'),
              'total'=>   $value
            ];
        return $data;
    }

    public function GetBranchSalesValueBetweenMonths($startDate , $endDate){

        // if($startDate == null && $endDate == null)
        // {
        //     $selected_month = Carbon::now()->format('Y-m-d'); // Get the current date in 'Y-m-d' format
        // }
        // else{
        //     $selected_month = Carbon::parse($date);
        // }

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
        // $data = $searchDTO;
        // $Name_column = 'Name';

        $NameResult = (new SalesRepository())->searchByName($searchDTO);

        // $Code_column = 'Code';
        $CodeResult =  (new SalesRepository())->searchByCode($searchDTO);

        $result = [];

        if($NameResult != null){
            $result[]= [$NameResult];
        }
        if($CodeResult != null){
            $result[]=[$CodeResult];
        }

        return $result;

        // $result = $this->
    }

}
