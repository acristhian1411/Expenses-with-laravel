<?php

namespace App\Http\Controllers\TillsProcess;

use App\Models\Tills;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TillDetails\TillDetailsController;
use Illuminate\Support\Facades\DB;

class TillsProcessController extends ApiController{
    /**
     * processes a cash opening 
     * @param int $till_id
     * @param int $amount
     * @return \Illuminate\Http\Response
     */
    public function open(Request $request){
        try{
            DB::beginTransaction();
            $till = Tills::findOrFail($request->till_id);
            $till->open();
            $now = date('Y-m-d');
            $detail = new TillDetailsController;
            $detail_data = new Request([
                'till_id' => $request->till_id,
                'person_id' => $request->person_id,
                'account_p_id' => 0,
                'td_desc' => 'Apertura de Caja',
                'td_date' => $now,
                'td_type' => true,
                'td_amount' => $request->td_amount
            ]);
            $detailMessage = $detail->store($detail_data);
            $details_id = $detailMessage->original['data']['id'];
            
            DB::commit();
            return response()->json(['message'=>'Caja abierta con exito']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo abrir la caja'],500);
        }
    }
}