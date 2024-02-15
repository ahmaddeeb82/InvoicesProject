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
        $branches = Sales::where('Code', '>', 2)->get(['Name','Number' , 'Code', 'GUID']);

        $salesDTO  = [];
        foreach($branches as $branch)
        {
            $salesDTO[]= [
                'branch' => $branch->Name,
                'code' => $branch->Code,
                'GUID' => $branch->GUID,
            ];
        }
        // dd($salesDTO);
        return $branches;
    }

    public function getBranchSales($salesDTO)
    {
           $totals = DB::connection('sqlsrv')->table('bu000')
            ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
            ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')
            ->where('bu000.Branch' ,$salesDTO->GUID)->sum('Total');

            // dd($totals);
         return $totals;
    }

    public function getById($id)
    {
     $branch = Sales::where('GUID' , $id)->get(['Name', 'Code', 'GUID'])->first();

     $salesDTO = new SalesDTO($branch->Name,
                              $branch->Code,
                              $branch->GUID);
        return $branch;
    }

    public function getTotalSalesValue(){
        $totalInvoicesValue = DB::connection('sqlsrv')->table('bu000')
        ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
        ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')->sum('Total');

        return $totalInvoicesValue;
    }

    public function getTotalSalesValueAtMonth($current_time)
    {
        $totalInvoicesValue = DB::connection('sqlsrv')->table('bu000')
        ->join('bt000', 'bu000.TypeGUID', '=', 'bt000.GUID')
        ->select('bu000.*', 'bt000.BillType')
        ->where('BillType', '1')
        ->whereDate('bu000.Date', $current_time)
        ->sum('Total');

        return $totalInvoicesValue;
    }

    public function searchByName($searchDTO)
    {
        $data = $searchDTO;
        $Name_column = 'Name';

        $NameResult = Sales::where($Name_column , $data)->orWhere($Name_column , 'LIKE' , '%' . $data . '%')->get(['Name' , 'Code' , 'GUID']);

        if($NameResult != null){


            $salesDTO = [];
            foreach($NameResult as $result)
            {
                $salesDTO [$result->GUID] = new SalesDTO(null , null , null);
            }

            // dd($NameResult);

            foreach($NameResult as $result){
                $salesDTO[$result->GUID]->branchName = $result->Name;
                $salesDTO[$result->GUID]->branchCode = $result->Code;
                $salesDTO[$result->GUID]->branchGUID = $result->GUID;

                // new SalesDTO(
                //     $result->get('Name'),
                //     $result->get('Code'),
                //     $result->get('GUID')
                // );
                // dd($result->GUID);
                // dd($salesDTO[$result->GUID]);

                $salesDTO[$result->GUID]->totalInvoices =  DB::connection('sqlsrv')->table('bu000')
                ->join('bt000' ,'bu000.TypeGUID' , '=' , 'bt000.GUID')
                ->select('bu000.*' , 'bt000.BillType')->where('BillType' , '1')
                ->where('bu000.Branch' ,$result->GUID)->sum('Total');
            }


            $salesResult = [];

            foreach($salesDTO as $result){
                $salesResult []= [
                    'name' => $result->branchName,
                    'code' => $result->branchCode,
                    'GUID' => $result->branchGUID,
                    'total sales' => $result->totalInvoices
                ];
            }


    //     $resultSalesDTO = new SalesDTO(
    //         $NameResult->get('Name'),
    //         $NameResult->get('Code'),
    //         $NameResult->get('GUID'),
    //         $this->getBranchSales($salesDTO)
    //     );
    }
        return $salesResult;

    }

    public function searchByCode($searchDTO)
    {
        $data = $searchDTO;
        $Name_column = 'Code';

        $CodeResult = Sales::where($Name_column , $data)->orWhere($Name_column , 'LIKE' , '%' . $data . '%')->get(['Name' , 'Code' , 'GUID']);

    //     if($CodeResult != null){
    //         // dd($CodeResult);
    //     $salesDTO = new SalesDTO(
    //         $CodeResult->get('Name'),
    //         $CodeResult->get('Code'),
    //         $CodeResult->get('GUID')
    //     );

    //     dd(   $CodeResult->get('Name'));

    //     $resultSalesDTO = new SalesDTO(
    //         $CodeResult->get('Name'),
    //         $CodeResult->get('Code'),
    //         $CodeResult->get('GUID'),
    //         $this->getBranchSales($salesDTO)
    //     );
    // }
        return $CodeResult;
    }
}
