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
            ->where('bu000.Branch' ,$salesDTO->branchGUID)->sum('Total');

            // dd($totals);
         return $totals;
    }

    public function getById($id)
    {
     $branch = Sales::where('GUID' , $id)->get(['Name', 'Code', 'GUID'])->first();

     $salesDTO = new SalesDTO($branch->Name,
                              $branch->Code,
                              $branch->GUID);
        return $salesDTO;
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
}
