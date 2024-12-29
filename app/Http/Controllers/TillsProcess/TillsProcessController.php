<?php

namespace App\Http\Controllers\TillsProcess;

use App\Models\Tills;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TillDetails\TillDetailsController;
use App\Http\Controllers\TillDetailProofPayments\TillDetailProofPaymentsController;
use Illuminate\Support\Facades\DB;

class TillsProcessController extends ApiController{
    /**
     * processes a cash opening 
     * @param int $till_id
     * @param int $amount
     * @return \Illuminate\Http\Response
     */
    public function cashOpening(Request $request){
        $rules = [
            'till_id' => 'required|integer', 
            'person_id' => 'required|integer', 
            'td_amount' => 'required|numeric'
        ];
        $request->validate($rules);
            try{
                // DB::beginTransaction();
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
                    'ref_id'=> 0,
                    'td_amount' => intval($request->td_amount)
                ]);
                $detailMessage = $detail->store($detail_data);
                $details_id = $detailMessage->original['data']['id'];
                $detProofPayment = new TillDetailProofPaymentsController;
                $proofs = new Request([
                    'till_detail_id'=>$details_id,
                    'proof_payment_id'=>1,
                    'td_pr_desc'=>'Ninguno'
                ]);
                $detProofPayment->store($proofs);
                // DB::commit();
                return response()->json(['message'=>'Caja abierta con exito']);
            }catch(\Exception $e){
                // DB::rollback();
                return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo abrir la caja'],500);
            }catch(\Illuminate\Validation\ValidationException $e){
                // DB::rollback();
                return response()->json(['error'=>$e->getMessage(),'message'=>'Los datos enviados no son correctos'],420);
            }
    }

    /**
     * processes a cash closing
     * @param int $till_id
     * @param int $amount
     * @return \Illuminate\Http\Response
     */
    public function close(Request $request){
        $rules = [
            'till_id' => 'required|integer', 
            'person_id' => 'required|integer', 
            'td_amount' => 'required|numeric'
        ];
        $request->validate($rules);
        try{
                $till = Tills::findOrFail($request->till_id);
                $till->close();
                $now = date('Y-m-d');
                
                $detail = new TillDetailsController;
                $detail_data = new Request([
                    'till_id' => $request->till_id,
                    'person_id' => $request->person_id,
                    'account_p_id' => 0,
                    'td_desc' => 'Cierre de Caja',
                    'td_date' => $now,
                    'ref_id'=>0,
                    'td_type' => false,
                    'td_amount' => $request->td_amount
                ]);
                $detailMessage = $detail->store($detail_data);
                
                $details_id = $detailMessage->original['data']['id'];
                
                $detProofPayment = new TillDetailProofPaymentsController;
                $proofs = new Request([
                    'till_detail_id'=>$details_id,
                    'proof_payment_id'=>1,
                    'td_pr_desc'=>'Ninguno'
                ]);
                $detProofPayment->store($proofs);
                
                return response()->json(['message'=>'Caja cerrada con exito']);
            
        }catch(\Exception $e){
            
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo cerrar la caja'],500);
        }
    }

    /**
     * processes a cash deposit
     * @param int $till_id
     * @param int $amount
     * @return \Illuminate\Http\Response
     */
    public function deposit(Request $request){
        $rules = [
            'till_id' => 'required|integer', 
            'person_id' => 'required|integer', 
            'td_amount' => 'required|numeric'
        ];
        $request->validate($rules);
        try{
            $now = date('Y-m-d');
            
            $detail = new TillDetailsController;
            $detail_data = new Request([
                'till_id' => $request->till_id,
                'person_id' => $request->person_id,
                'account_p_id' => 0,
                'td_desc' => 'Ingreso de Efectivo',
                'td_date' => $now,
                'ref_id'=>0,
                'td_type' => true,
                'td_amount' => $request->td_amount
            ]);
            $detailMessage = $detail->store($detail_data);
            
            $details_id = $detailMessage->original['data']['id'];
            
            $detProofPayment = new TillDetailProofPaymentsController;
            $proofs = new Request([
                'till_detail_id'=>$details_id,
                'proof_payment_id'=>1,
                'td_pr_desc'=>'Ninguno'
            ]);
            $detProofPayment->store($proofs);
            
            return response()->json(['message'=>'Deposito realizado con exito']);
            
        }catch(\Exception $e){
            
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo realizar el deposito'],500);
        }
    }
}