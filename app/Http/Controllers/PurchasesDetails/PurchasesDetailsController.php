<?php

namespace App\Http\Controllers\PurchasesDetails;

use App\Models\PurchasesDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PurchasesDetailsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = PurchasesDetails::query()->first();
        $query = PurchasesDetails::query();
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
            'purchase_id' => 'required',
            'product_id' => 'required',
            'pd_desc' => 'required',
            'pd_qty' => 'required',
            'pd_amount' => 'required'
        ];
        $this->validate($request, $reglas);
        $purchasesDetails = PurchasesDetails::create($request->all());
        return $this->showOne($purchasesDetails, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchasesDetails  $purchasesDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $purchasesDetails = PurchasesDetails::findOrFail($id);
        return $this->showOne($purchasesDetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchasesDetails  $purchasesDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $reglas = [
            'purchase_id' => 'required',
            'product_id' => 'required',
            'pd_desc' => 'required',
            'pd_qty' => 'required',
            'pd_amount' => 'required'
        ];
        $this->validate($request, $reglas);
        $purchasesDetails = PurchasesDetails::findOrFail($id);
        $purchasesDetails->update($request->all());
        return $this->showOne($purchasesDetails, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchasesDetails  $purchasesDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $purchasesDetails = PurchasesDetails::findOrFail($id);
        $purchasesDetails->delete();
        return response()->json('Eliminado con exito!');

    }
}
