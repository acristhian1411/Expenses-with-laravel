<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Purchases\PurchasesController;
use App\Http\Controllers\PurchasesDetails\PurchasesDetailsController;
use Illuminate\Support\Collection;
class PurchaseStoreController extends ApiController {
    /**
     * Use the store method of PurchasesController and PurchasesDetailsController to create a new purchase with each details. Also it will use DBTransaction
     * 
     * @param int $person_id
     * @param string $purchase_date
     * @param string $purchase_number
     * @param array $purchase_details
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try{
            DB::beginTransaction();
            $reglas = [
                'person_id' => 'required|integer',
                'purchase_date' => 'required|date',
                'purchase_number' => 'required|string|unique:purchases',
                'purchase_details' => 'required|array'
            ];
            $request->validate($reglas);
            $purchases = new PurchasesController;
            $purchase_data = new Request([
                'person_id' => $request->person_id,
                'purchase_date' => $request->purchase_date,
                'purchase_number' => $request->purchase_number,
            ]);
            $ret = $purchases->store($purchase_data);
            $purchase_id = $ret->original['data']['id'];
            $purchase_details = new PurchasesDetailsController;
            $details = collect($request->purchase_details)->map(function ($item) use ($purchase_id) {
                return array_merge($item, ['purchase_id' => $purchase_id]);
            })->toArray();
            $purchase_details_data = new Request([
                'details' => $details
            ]);
            $det = $purchase_details->storeMany($purchase_details_data);
            DB::commit();
            $something = [];
            return $this->showAfterAction($something,'create', 201);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['error' => $e->getMessage(), 'message'=>'Ocurrió un error mientras se creaba el registro'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            DB::rollBack();
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null
            ]);
        }
        
    }
}