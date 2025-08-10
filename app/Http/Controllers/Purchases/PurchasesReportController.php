<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Purchases;
use Illuminate\Support\Facades\DB;
use PDF;
    
class PurchasesReportController extends ApiController
{
    public function getPurchasesReport(Request $request){
        try{
            $subquery = DB::table('purchases_details as pd')
            ->select('pd.purchase_id', DB::raw('SUM(pd.pd_amount) as total'))
            ->groupBy('pd.purchase_id');
            $purchases = Purchases::query()
            ->join('persons', 'purchases.person_id', '=', 'persons.id')
            ->joinSub($subquery, 'd', function ($join) {
                $join->on('d.purchase_id', '=', 'purchases.id');
            })
            ->where('purchase_date', '>=', $request->start_date)
            ->where('purchase_date', '<=', $request->end_date)
            ->select('purchases.purchase_date as date', 'purchases.purchase_number as number', 'persons.person_fname', 'persons.person_lastname', 'd.total');
            if($request->has('entity') and $request->entity != null){
                $purchases = $purchases->where('person_id', $request->entity);
            }
            $purchases = $purchases->get();
            if($request->from_view != 'false'){
                return $this->showAll($purchases, 'api','',200);
            }
            
            $data = [
                'title' => 'Reporte de compras',
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'date' => date('Y-m-d'),
                'purchases' => $purchases
            ]; 
                  
            $pdf = PDF::loadView('Purchases.PurchasesReport', $data);
           
            return response()->stream(function() use ($pdf) {
                echo $pdf->stream();
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="purchases_report.pdf"'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e,
                'message'=>'No se pudo obtener los datos'
            ], 500);
        }
    }
}
