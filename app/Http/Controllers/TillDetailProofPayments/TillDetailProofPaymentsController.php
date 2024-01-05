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
        //
        $t = TillDetailProofPayments::query()->first();
        $query = TillDetailProofPayments::query();
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
        $reglas = [
            'proof_payment_id' => 'required|integer',
            'till_detail_id' => 'required|integer',
            'td_pr_desc' => 'required|string',
        ];
        $this->validate($request, $reglas);
        $data = $request->all();
        $tillDetailProofPayments = TillDetailProofPayments::create($data);
        return $this->showOne($tillDetailProofPayments, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TillDetailProofPayments  $tillDetailProofPayments
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
        $tillDetailProofPayments = TillDetailProofPayments::findOrFail($id);
        return $this->showOne($tillDetailProofPayments, 200);
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
        //
        $reglas = [
            'proof_payment_id' => 'required|integer',
            'till_detail_id' => 'required|integer',
            'td_pr_desc' => 'required|string',
        ];
        $this->validate($request, $reglas);
        $tillDetailProofPayments = TillDetailProofPayments::findOrFail($id);
        $tillDetailProofPayments->update($request->all());
        return $this->showOne($tillDetailProofPayments, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TillDetailProofPayments  $tillDetailProofPayments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tillDetailProofPayments = TillDetailProofPayments::findOrFail($id);
        $tillDetailProofPayments->delete();
        return response()->json('Eliminado con exito');

    }
}
