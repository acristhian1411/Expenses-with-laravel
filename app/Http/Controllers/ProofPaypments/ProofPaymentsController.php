<?php

namespace App\Http\Controllers\ProofPaypments;

use App\Models\ProofPayments;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;


class ProofPaymentsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = ProofPayments::query()->first();
        $query = ProofPayments::query();
        $query = $this->filterData($query, $t);
        $datos = $query->get();
        return $this->showAll($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'proof_payment_desc' => 'required|string|max:255',
            'payment_type_id' => 'required|integer',
        ];
        $this->validate($request, $rules);
        $dato = ProofPayments::create($request->all());
        return $this->showOne($dato, 201);
    }

    //
    public function storeMultiple(Request $request)
    {
        //
        $proofPayments = ProofPayments::insert($request->all());
        return response()->json(['data'=>$proofPayments]);
    }

    //
    public function showByType($payment_type_id){
        $proofPayments = ProofPayments::join('payment_types','payment_types.id','=','proof_payments.payment_type_id')
        ->where('payment_type_id', $payment_type_id)
        ->select('proof_payments.*','payment_types.payment_type_desc')
        ->get();
        
        return $this->showAll($proofPayments, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProofPayments  $proofPayments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $proofPayments = ProofPayments::findOrFail($id);
        return $this->showOne($proofPayments);
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
        //
        $rules = [
            'proof_payment_desc' => 'required|string|max:255',
            'payment_type_id' => 'required|integer',
        ];
        $this->validate($request, $rules);
        $proofPayments = ProofPayments::findOrFail($id);
        $proofPayments->update($request->all());
        return $this->showOne($proofPayments, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProofPayments  $proofPayments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $proofPayments = ProofPayments::findOrFail($id);
        $proofPayments->delete();
        return response()->json('Eliminado con exito');
    }
}
