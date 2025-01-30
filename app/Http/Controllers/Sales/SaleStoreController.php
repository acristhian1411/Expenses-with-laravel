<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\SalesDetails\SalesDetailsController;
use App\Http\Controllers\TillDetails\TillDetailsController;
use App\Http\Controllers\TillDetailProofPayments\TillDetailProofPaymentsController;
use App\Http\Controllers\Tills\TillsController;
use App\Http\Controllers\Products\ProductsController;
use Illuminate\Support\Collection;
class SaleStoreController extends ApiController {
    /**
     * Use the store method of SalesController and SalesDetailsController to create a new sale with each details. Also it will use DBTransaction
     * 
     * @param int $person_id
     * @param string $sale_date
     * @param string $sale_number
     * @param array $sale_details
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try{
            DB::beginTransaction();
            $reglas = [
                'user_id' => 'required|integer',
                'person_id' => 'required|integer',
                'sale_date' => 'required|date',
                'sale_number' => 'required|string|unique:Sales',
                'sale_details' => 'required|array'
            ];
            $request->validate($reglas);
            // Check if there is enough cash in the till to make the sale
            $tills = new TillsController;
            $till_data = new Request([
                'fromController'=> true
            ]);
            
            $product_data = new Request([
                'fromController' => true,
                'details' => collect($request->sale_details)->map(function ($item) {
                    return [
                        'id' => $item['product_id'],
                        'product_cost_price' => $item['pd_amount'],
                        'product_quantity' => $item['pd_qty']
                    ];
                })->toArray()
            ]);
            $products = new ProductsController;
            $update = $products->updatePriceAndQty($product_data);
            $Sales = new SalesController;
            $sale_data = new Request([
                'person_id' => $request->person_id,
                'sale_date' => $request->sale_date,
                'sale_number' => $request->sale_number,
            ]);
            $ret = $Sales->store($sale_data);
            $sale_id = $ret->original['data']['id'];
            $sale_details = new SalesDetailsController;
            $details = collect($request->sale_details)->map(function ($item) use ($sale_id) {
                return array_merge($item, [
                    'sale_id' => $sale_id,
                    'created_at' => now(),
                    'updated_at' => now()
            ]);
            })->toArray();
            $sale_details_data = new Request([
                'details' => $details
            ]);
            $det = $sale_details->storeMany($sale_details_data);
            $till_details = new TillDetailsController;
            $till_details_data = new Request([
                'till_id' => $request->till_id,
                'account_p_id'=> 1,
                'ref_id' => $sale_id,
                'person_id' => $request->user_id,
                'td_desc' => "Compra {$request->sale_number}",
                'td_date' => $request->sale_date,
                'td_type' => false,
                'td_amount' => $sale_amount
            ]);
            $till_detail_stored = $till_details->store($till_details_data);
            $till_detail_proof_payments = new TillDetailProofPaymentsController;
            $till_detail_proof_payments_data = new Request([
                'till_detail_id' => $till_detail_stored->original['data']['id'],
                'proof_payment_id' => $request->proofPayments[0]['value'],
                'td_pr_desc' => $request->proofPayments[0]['value'] == 1 ? 'Efectivo' : $request->proofPayments[0]['td_pr_desc'],
            ]);
            $till_detail_proof_payments_stored = $till_detail_proof_payments->store($till_detail_proof_payments_data);
            
            DB::commit();
            $something = [];
            return $this->showAfterAction($something,'create', 201);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['error' => $e, 'message'=>'Ocurrió un error mientras se creaba el registro'],500);
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