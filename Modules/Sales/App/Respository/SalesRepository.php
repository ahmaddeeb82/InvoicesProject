<?php

namespace Modules\Sales\App\Respository;

use Modules\Sales\App\Models\Sales;

use Modules\Sales\App\DTOs\SalesDTO;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class SalesRepository{

    public function __construct(){}

    public function getAll()
    {
        $branches = Sales::where('Code', '>', 2)->get(['Name','Number', 'GUID']);

        $salesDTO  = [];
        foreach($branches as $branch)
        {
            $salesDTO[]= [
                'branch' => $branch->Name,
                'number' => $branch->Number,
                'GUID' => $branch->GUID,
            ];
        }
        // dd($salesDTO);
        return $branches;
    }

    public function getBranchSales($salesDTO)
    {
           $totals = DB::connection('sqlsrv_second')->table('bu000')
            ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
            ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')
            ->where('bu000.Branch' ,$salesDTO->GUID)->sum('Total');

            // dd($totals);
         return $totals;
    }

    public function getBranchSalesBetweenMonths($salesDTO , $startDate , $endDate)
    {
           $totals = DB::connection('sqlsrv_second')->table('bu000')
            ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
            ->select('bu000.*' , 'bt000.BillType')
            ->where('BillType' , '1')
            ->where('bu000.Branch' ,$salesDTO->GUID)
            ->whereBetween('Date' , [$startDate , $endDate])
            ->sum('Total');

            // dd($totals);
         return $totals;
    }

    public function getById($id)
    {
     $branch = Sales::where('GUID' , $id)->get(['Name', 'Number', 'GUID'])->first();

     $salesDTO = new SalesDTO($branch->Name,
                              $branch->Number,
                              $branch->GUID);
        return $branch;
    }

    public function getTotalSalesValue(){
        $totalInvoicesValue = DB::connection('sqlsrv_second')->table('bu000')
        ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
        ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')->sum('Total');

        return $totalInvoicesValue;
    }

    public function getTotalSalesValueAtMonth($current_time)
    {
        $totalInvoicesValue = DB::connection('sqlsrv_second')->table('bu000')
        ->join('bt000', 'bu000.TypeGUID', '=', 'bt000.GUID')
        ->select('bu000.*', 'bt000.BillType')
        ->where('BillType', '1')
        ->whereDate('bu000.Date', $current_time)
        ->sum('Total');

        return $totalInvoicesValue;
    }

    public function getTotalSalesValueAtBetweenMonths($startDate , $endDate)
    {
        $totalInvoicesValue = DB::connection('sqlsrv_second')->table('bu000')
        ->join('bt000', 'bu000.TypeGUID', '=', 'bt000.GUID')
        ->select('bu000.*', 'bt000.BillType')
        ->where('BillType', '1')
        ->whereBetween('bu000.Date' ,[$startDate , $endDate] )
        ->sum('Total');

        return $totalInvoicesValue;
    }

    public function searchByName($searchDTO)
    {
        $data = $searchDTO;
        $Name_column = 'Name';

        $NameResult = Sales::where($Name_column , $data)->orWhere($Name_column , 'LIKE' , '%' . $data . '%')->get(['Name' , 'Number' , 'GUID']);

        if($NameResult != null){


            $salesDTO = [];
            foreach($NameResult as $result)
            {
                $salesDTO [$result->GUID] = new SalesDTO(null , null , null);
            }

            // dd($NameResult);

            foreach($NameResult as $result){
                $salesDTO[$result->GUID]->branchName = $result->Name;
                $salesDTO[$result->GUID]->branchNumber = $result->Number;
                $salesDTO[$result->GUID]->branchGUID = $result->GUID;

                $salesDTO[$result->GUID]->totalInvoices =  DB::connection('sqlsrv_second')->table('bu000')
                ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
                ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')
                ->where('bu000.Branch' ,$result->GUID)->sum('Total');
            }


            $salesResult = [];

            foreach($salesDTO as $result){
                $salesResult []= [
                    'name' => $result->branchName,
                    'number' => $result->branchNumber,
                    'GUID' => $result->branchGUID,
                    'total sales' => $result->totalInvoices
                ];
            }
    }
        return $salesResult;

    }

    public function searchByNumber($searchDTO)
    {
        $data = $searchDTO;
        $Name_column = 'Number';

        $NumberResult = Sales::where($Name_column , $data)->orWhere($Name_column , 'LIKE' , '%' . $data . '%')->get(['Name' , 'Number' , 'GUID']);

        return $NumberResult;
    }
}
