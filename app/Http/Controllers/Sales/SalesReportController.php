<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;
use PDF;
class SalesReportController extends ApiController
{
    public function getSalesReport(Request $request){
        try{
            $subquery = DB::table('sales_details as sd')
            ->select('sd.sale_id', DB::raw('SUM(sd.sd_amount) as total'))
            ->groupBy('sd.sale_id');
            $sales = Sales::query()
            ->join('persons', 'sales.person_id', '=', 'persons.id')
            ->joinSub($subquery, 'd', function ($join) {
                $join->on('d.sale_id', '=', 'sales.id');
            })
            ->where('sale_date', '>=', $request->start_date)
            ->where('sale_date', '<=', $request->end_date)
            ->select('sales.sale_date as date', 'sales.sale_number as number', 'persons.person_fname', 'persons.person_lastname', 'd.total')
            ->get();
            if($request->has('entity') and $request->entity != null){
                $sales = $sales->where('person_id', $request->entity);
            }
            if($request->from_view != 'false'){
                return $this->showAll($sales, 'api','',200);
            }
            
            $data = [
                'title' => 'Reporte de ventas',
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'date' => date('Y-m-d'),
                'sales' => $sales
            ]; 
                  
            $pdf = PDF::loadView('Sales.SalesReport', $data);
           
            return response()->stream(function() use ($pdf) {
                echo $pdf->stream();
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="sales_report.pdf"'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'No se pudo obtener los datos'
            ], 500);
        }
    }
}
