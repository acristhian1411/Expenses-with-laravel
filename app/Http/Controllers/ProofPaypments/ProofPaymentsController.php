<?php

namespace App\Http\Controllers\ProofPaypments;

use App\Models\ProofPayments;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;

class ProofPaymentsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = ProofPayments::query()->first();
            $query = ProofPayments::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo obtener los datos']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $rules = [
                'proof_payment_desc' => 'required|string|max:255',
                'payment_type_id' => 'required|integer',
            ];
            $request->validate($rules);
            $dato = ProofPayments::create($request->all());
            return response()->json([
                'message'=>'Registro creado con exito',
                'data'=>$dato
            ],201);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo crear registro'],400);
        }
    }

    //
    public function storeMultiple(Request $request)
    {
        try{
            $validated = $request->validate([
                'payments' => 'required|array',  
                'payments.*.proof_payment_desc' => 'required|string', 
                'payments.*.payment_type_id' => 'required|int'
            ]);
            $proofPayments = ProofPayments::insert($validated['payments']);
            return response()->json(['data'=>$proofPayments]);
        }catch(\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Database Error', 'message' => $e->getMessage()], 500);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo crear registro'],400);
        }
    }

    //
    public function showByType($payment_type_id){
        try{
            $proofPayments = ProofPayments::join('payment_types','payment_types.id','=','proof_payments.payment_type_id')
            ->where('payment_type_id', $payment_type_id)
            ->select('proof_payments.*','payment_types.payment_type_desc',
            DB::raw("false as edited"),
            DB::raw("true as created")
            )
            ->get();
            
            return $this->showAll($proofPayments, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo obtener los datos'], 400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProofPayments  $proofPayments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $proofPayments = ProofPayments::findOrFail($id);
            $audits = $proofPayments->audits;
            return $this->showOne($proofPayments, $audits,200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo obtener los datos'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProofPayments  $proofPayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $rules = [
                'proof_payment_desc' => 'required|string|max:255',
                'payment_type_id' => 'required|integer',
            ];
            $request->validate($rules);
            $proofPayments = ProofPayments::findOrFail($id);
            $proofPayments->update($request->all());
            return response()->json(['message'=>'Registro actualizado con exito']);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo actualizar los datos']);
        }
    }

    public function updateMultiple(Request $request){
        try{
            $validated = $request->validate([
                'payments' => 'required|array', 
                'payments.*.proof_payment_desc' => 'required|string', 
                'payments.*.payment_type_id' => 'required|int',
                'payments.*.id' => 'required|int'
            ]);
            foreach ($validated['payments'] as $key => $value) {
                // dd($value);
                $proofPayments = ProofPayments::findOrFail($value['id']);
                $proofPayments->update($value);
            }
            return response()->json(['message'=>'Registro actualizado con exito']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo actualizar los datos'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProofPayments  $proofPayments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $proofPayments = ProofPayments::findOrFail($id);
            $proofPayments->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo eliminar los datos']);
        }
    }
}
