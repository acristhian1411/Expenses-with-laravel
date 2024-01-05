<?php

namespace App\Http\Controllers\PaymentTypes;

use App\Models\PaymentTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PaymentTypesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $t = PaymentTypes::query()->first();
        $query = PaymentTypes::query();
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
            'payment_type_desc' => 'required'
        ];

        $this->validate($request, $reglas);
        $paymentTypes = PaymentTypes::create($request->all());
        return $this->showOne($paymentTypes, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentTypes  $paymentTypes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $paymentTypes = PaymentTypes::findOrFail($id);
        return $this->showOne($paymentTypes, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentTypes  $paymentTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $reglas = [
            'payment_type_desc' => 'required'
        ];
        $this->validate($request, $reglas);
        $paymentTypes = PaymentTypes::findOrFail($id);
        $paymentTypes->update($request->all());
        return $this->showOne($paymentTypes, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentTypes  $paymentTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //

        $paymentTypes = PaymentTypes::findOrFail($id);
        $paymentTypes->delete();
        return response()->json('Eliminado con exito');
    }
}
