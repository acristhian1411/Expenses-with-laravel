<?php

namespace App\Http\Controllers\TillDetailProofPayments;

use App\Models\TillDetailProofPayments;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TillDetailProofPaymentsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = TillDetailProofPayments::query()->first();
            $query = TillDetailProofPayments::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
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
            $reglas = [
                'proof_payment_id' => 'required|integer',
                'till_detail_id' => 'required|integer',
                'td_pr_desc' => 'required|string',
            ];
            $request->validate($reglas);
            $data = $request->all();
            $tillDetailProofPayments = TillDetailProofPayments::create($data);
            return $this->showAfterAction($tillDetailProofPayments,'create', 201);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo guardar los datos'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Ls datos no son correrctos',
                'details'=> method_exists($e, 'errors') ? $e->errors() : null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TillDetailProofPayments  $tillDetailProofPayments
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try{
            $tillDetailProofPayments = TillDetailProofPayments::findOrFail($id);
            $audits = $tillDetailProofPayments->audits;
            return $this->showOne($tillDetailProofPayments,$audits, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TillDetailProofPayments  $tillDetailProofPayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $reglas = [
                'proof_payment_id' => 'required|integer',
                'till_detail_id' => 'required|integer',
                'td_pr_desc' => 'required|string',
            ];
            $request->validate($reglas);
            $tillDetailProofPayments = TillDetailProofPayments::findOrFail($id);
            $tillDetailProofPayments->update($request->all());
            return $this->showAfterAction($tillDetailProofPayments,'update', 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo actualizar los datos'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Ls datos no son correrctos',
                'details'=> method_exists($e, 'errors') ? $e->errors() : null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TillDetailProofPayments  $tillDetailProofPayments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $tillDetailProofPayments = TillDetailProofPayments::findOrFail($id);
            $tillDetailProofPayments->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar los datos'],500);
        }
    }
}
